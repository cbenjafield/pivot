<?php

namespace Benjafield\Checkout;

use App\Checkout\Product;
use Benjafield\Checkout\Exceptions\InvalidItemIDException;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Closure;
use Checkout;

class Basket
{
	/**
	 * Store the session instance.
	 *
	 * @var \Illuminate\Session\SessionManager
	 */
	private $session;

	/**
	 * Store the event dispatcher instance.
	 *
	 * @var \Illuminate\Contracts\Events\Dispatcher
	 */
	private $events;

	/**
	 * Store the basket name.
	 *
	 * @var string
	 */
	private $basketName = 'basket';

	/**
	 * Basket constructor.
	 *
	 * @param \Illuminate\Session\SessionManager      $session
	 * @param \Illuminate\Contracts\Events\Dispatcher $events
	 */
	public function __construct(SessionManager $session, Dispatcher $events)
	{
		$this->session = $session;
		$this->events = $events;
	}

	/**
	 * Add an item to the cart.
	 *
	 * @param  mixed  $type
	 * @param  mixed  $id
	 * @param  string $name
	 * @param  int    $quantity
	 * @param  float  $price
	 * @param  array  $options
	 * @return \Cbenjafield\DrivingSchoolBasket\BasketItem
	 */
	public function add($type, $id, $name = null, $quantity = null, $price = null, $group = null, $category = null, array $options = [])
	{
		$basketItem = $this->createBasketItem($type, $id, $name, $quantity, $price, $group, $category, $options);

		$contents = $this->getContents();

		if($contents->has($basketItem->itemId)) {
			$basketItem->quantity += $contents->get($basketItem->itemId)->quantity;
		}

		$contents->put($basketItem->itemId, $basketItem);

		$this->events->dispatch('basket.added', $basketItem);

		$this->session->put($this->basketName, $contents);

		return $basketItem;
	}

	public function hasServices()
	{
		$contents = $this->getContents();

		$services = $contents->where('type', 'App\\Service')->count();

		return !! $services;
	}

	public function hasProducts()
	{
		$contents = $this->getContents();

		$products = $contents->where('type', 'App\\Product')->count();

		return !! $products;
	}

	/**
	 * Update the cart item with the supplied itemId.
	 *
	 * @param  string $itemId
	 * @param  int    $quantity
	 * @return \Cbenjafield\DrivingSchoolBasket\BasketItem
	 */
	public function update($itemId, $quantity)
	{
		$basketItem = $this->get($itemId);

		$basketItem->quantity = $quantity;

		$contents = $this->getContents();

		if($itemId !== $basketItem->itemId) {
			$contents->pull($itemId);

			if($contents->has($basketItem->itemId)) {
				$existingBasketItem = $this->get($basketItem->itemId);
				$basketItem->setQuantity($existingBasketItem->quantity + $basketItem->quantity);
			}
		}

		if($basketItem->quantity <= 0) {
			$this->remove($basketItem->itemId);
			return;
		} else {
			$contents->put($basketItem->itemId, $basketItem);
		}

		$this->events->dispatch('basket.updated', $basketItem);

		$this->session->put($this->basketName, $contents);

		return $basketItem;
	}

	/**
	 * Remove item from the basket.
	 *
	 * @param  string $itemId
	 * @return void
	 */
	public function remove($itemId)
	{
		$basketItem = $this->get($itemId);

		$contents = $this->getContents();

		$contents->pull($basketItem->itemId);

		$this->events->dispatch('basket.removed', $basketItem);

		$this->session->put($this->basketName, $contents);
	}

	/**
	 * Get a cart item by the itemId.
	 *
	 * @param  string $itemId
	 * @return \Cbenjafield\DrivingSchoolBasket\BasketItem
	 */
	public function get($itemId)
	{
		$contents = $this->getContents();

		if(!$contents->has($itemId)) throw new InvalidItemIDException("The basket does not contain an item with the ID {$itemId}");

		return $contents->get($itemId);
	}

	/**
	 * Destroy the current basket instance.
	 *
	 * @return void
	 */
	public function destroy()
	{
		$this->session->remove($this->basketName);
	}

	/**
	 * Get the contents of the current basket instance.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function contents()
	{
		if(is_null($this->session->get($this->basketName))) return new Collection([]);

		return $this->session->get($this->basketName);
	}

	/**
	 * Get the total number of items in the basket.
	 *
	 * @return int
	 */
	public function count()
	{
		$contents = $this->getContents();

		return $contents->sum('quantity');
	}

	/**
	 * Get the total price of the items in the basket.
	 *
	 * @param  int    $decimalPlaces
	 * @param  string $decimalPoint
	 * @param  string $thousandSeparator
	 * @return string
	 */
	public function total($fee = true, $decimalPlaces = null, $decimalPoint = null, $thousandSeparator = null)
	{
		$contents = $this->getContents();

		$total = $contents->reduce(function ($total, BasketItem $basketItem) {
			return $total + ($basketItem->quantity * $basketItem->price);
		}, 0);

		if(Checkout::isVoucherDelivery()) {
			$total = $total + 1.99;
		}

		if($this->hasServices() && $fee) {
			$total = $total + $total * 0.045;
		}

		return $this->formatNumber($total, $decimalPlaces, $decimalPoint, $thousandSeparator);
	}

	/**
	 * Get the total price of the items in the basket in pence.
	 *
	 * @return string
	 */
	public function penceTotal($fee = true, $decimalPlaces = null, $decimalPoint = null, $thousandSeparator = null)
	{
		return $this->total($fee, $decimalPlaces, $decimalPoint, $thousandSeparator) * 100;
	}

	/**
	 * Search the basket for an item matching the given closure.
	 * @param  \Closure $search
	 * @return \Illuminate\Support\Collection
	 */
	public function search(Closure $search)
	{
		$contents = $this->getContents();

		return $contents->filter($search);
	}

	/**
	 * Getter for total and subtotal properties.
	 *
	 * @param  string $attribute
	 * @return mixed
	 */
	public function __get($attribute)
	{
		if($attribute === 'total') return $this->total();

		return null;
	}

	/**
	 * Get the contents of the basket. If there is nothing set, return an empty collection.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	protected function getContents()
	{
		$contents = $this->session->has($this->basketName)
			? $this->session->get($this->basketName)
			: new Collection;

		return $contents;
	}

	/**
	 * Create a new BasketItem from the given attributes.
	 *
	 * @param  string $type
	 * @param  mixed $id
	 * @param  mixed $name
	 * @param  int   $quantity
	 * @param  array $options
	 * @return \Cbenjafield\DrivingSchoolBasket\BasketItem
	 */
	private function createBasketItem($type, $id, $name, $quantity, $price, $group, $category = null, array $options = [])
	{
		$basketItem = BasketItem::fromAttributes($type, $id, $name, $price, $group, $category, $options);
		$basketItem->setQuantity($quantity);

		return $basketItem;
	}

	/**
	 * Check if the item is a multidimensional array.
	 *
	 * @param  mixed $item
	 * @return bool
	 */
	private function isMultiple($item)
	{
		if(!is_array($item)) return false;

		return is_array(head($item));
	}

	/**
	 * Returns a number format.
	 *
	 * @param  float  $value
	 * @param  int    $decimalPlaces
	 * @param  string $decimalPoint
	 * @param  string $thousandSeparator
	 * @return string
	 */
	protected function formatNumber($value, $decimalPlaces, $decimalPoint, $thousandSeparator)
	{
		if(is_null($decimalPlaces)) $decimalPlaces = is_null(config('basket.format.decimal_places')) ? 2 : config('basket.format.decimal_places');
		if(is_null($decimalPoint)) $decimalPoint = is_null(config('basket.format.decimal_point')) ? '.' : config('basket.format.decimal_point');
		if(is_null($thousandSeparator)) $thousandSeparator = is_null(config('basket.format.thousand_separator')) ? ',' : config('basket.format.thousand_separator');

		return number_format($value, $decimalPlaces, $decimalPoint, $thousandSeparator);
	}

	/**
	 * Return the JSON representation of the basket.
	 *
	 * @param  int    $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		$contents = $this->getContents()->toJson();
		return $contents;
	}

	/**
	 * Get the Basket Instance's signature.
	 *
	 * @return string
	 */
	public function signature()
	{
		$parts = [
			$this->total(),
			$this->toJson(),
			request()->ip()
		];

		return sha1(implode(':', $parts));
	}

	public function getJsonItems()
	{
		$contents = $this->getContents();

		$basket = [];

		foreach($contents as $item) {
			$basket[$item->group] = [
				'itemid' => $item->id,
				'itemname' => $item->name,
				'itemprice' => (int) $item->pencePrice(),
				'itempricegroup' => $item->group,
				'quantity' => $item->quantity,
				'itemtype' => $item->getSingularType(),
				'is_dispatchable' => 1,
				'category' => $item->category ?? null,
			];
		}

		return json_encode($basket);
	}

	/**
	 * Generate the order description by concatenating the basket
	 * items.
	 *
	 * @return string
	 */
	public function description()
	{
		$contents = $this->getContents();

		$names = [];

		foreach($contents as $item) {
			$names[] = $item->name;
		}

		return implode(' + ', $names);
	}

	/**
	 * Determine if the basket is empty.
	 *
	 * @return bool
	 */
	public function isEmpty()
	{
		return !! empty($this->getContents());
    }


    public function setFakeData()
    {
        $fauxSessionData = [
            'Pass For Less Pack' => [
                'itemid' => 3274,
                'itemname' => 'Pass For Less Pack',
                'itemprice' => 24.99,
                'itempricegroup' => 'global',
                'quantity' => 1,
                'itemtype' => 'product',
                'limit' => 1,
                'offer' => 1,
                'permission' => null,
                'postage' => null,
                'is_dispatchable' => 0,
				'duration' => 1.00,
				'email' => true,
				'category' => 'bundle-pack',
            ]
        ];

        foreach($fauxSessionData as $item) {
            $this->add(
                'App\\Product',
                $item['itemid'],
                $item['itemname'],
                $item['quantity'],
                $item['itemprice'],
				$item['itempricegroup'],
				$item['category'] ?? null
            );
        }
    }

	public function setBasketData()
	{
		$checkoutData = $_SESSION['CheckoutData'];

		foreach($checkoutData as $item) {
            $this->add(
                ($item['itemtype'] == 'service' ? 'App\\Service' : 'App\\Product'),
                $item['itemid'],
                $item['itemname'],
                $item['quantity'],
                (((int) $item['itemprice']) / 100),
				$item['itempricegroup'],
				$item['category'] ?? null
            );
        }
	}

	public function paypalItems()
	{
		$items = [];

		foreach($this->getContents() as $item) {
			$ppItem = [
				'name' => $item->name,
				'sku' => $item->id,
				'unit_amount' => [
					'currency_code' => 'GBP',
					'value' => $item->price,
				],
				'quantity' => $item->quantity,
			];

			$items[] = $ppItem;
		}

		if($this->hasServices()) {
			$items[] = [
				'name' => 'Management & Protection Fee',
				'sku' => 'mmp45',
				'unit_amount' => [
					'currency_code' => 'GBP',
					'value' => number_format($this->total() - $this->total(false), 2),
				],
				'quantity' => 1
			];
		}

		return $items;
	}
}
