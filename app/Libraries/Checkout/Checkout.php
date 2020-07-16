<?php

namespace Benjafield\Checkout;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Checkout as CheckoutFacade;
use Illuminate\Support\Str;
use Basket;

class Checkout
{

    protected $session;

    protected $events;

    protected $checkoutName = 'checkout';

    protected $successName = 'success';

    protected $orderName = 'order';

    public function __construct(SessionManager $session, Dispatcher $events)
    {
        $this->session = $session;
        $this->events = $events;
    }

    public function getContents()
    {
        return $this->session->has($this->checkoutName)
                        ? $this->session->get($this->checkoutName)
                        : new Collection;
    }

    public function setDeliveryAddress(array $address)
    {
        $this->putSessionSection('delivery_address', $this->createAddress($address));

        return $this;
    }

    public function setPickupAddress(array $address)
    {
        $this->putSessionSection('pickup_address', $this->createAddress($address));

        return $this;
    }

    public function setBillingAddress(array $address)
    {
        $this->putSessionSection('billing_address', $this->createAddress($address));

        return $this;
    }

    protected function createAddress(array $address)
    {
        return new Address($address);
    }

    public function putSessionSection($key, $value)
    {
        $contents = $this->getContents();

        if($contents->has($key)) {
            $contents->pull($key);
        }

        $contents->put($key, $value);

        $this->session->put($this->checkoutName, $contents);
    }

    public function get($key)
    {
        $contents = $this->getContents();

        if($contents->has($key)) return $contents->get($key);

        return null;
    }

    public function has($key)
    {
        $contents = $this->getContents();
        
        return $contents->has($key);
    }

    public function getAddressJson($key) {
        if(empty($this->get($key))) {
            return null;
        }
        
        return $this->get($key)->toJson();
    }

    public function destroy()
    {
        $this->session->remove($this->checkoutName);
    }

    public function verify($key, $redirectPath = '/')
    {
        $contents = $this->getContents();

        $basketContents = Basket::contents();

        if(! $basketContents->count()) {
            return $this->redirect($redirectPath);
        }

        if(! $contents->has($key)) {
            return $this->redirect($redirectPath);
        }

        return true;
    }

    public function createUser($name, $email, $phone, $pupilName)
    {
        $user = new CheckoutUser($name, $email, $phone, $pupilName);

        $this->putSessionSection('user', $user);

        return $user;
    }

    public function addAddress($name, array $components = [])
    {
        $address = new Address($components);

        $this->putSessionSection($name, $address);

        return $address;
    }

    public function setTransactionId()
    {
        $transactionId = 'DJ-' . Str::uuid();

        $this->putSessionSection('transaction_id', $transactionId);

        return $transactionId;
    }

    public function setSuccessData($gatewayMessage = null, $authCode = null)
    {
        $data = new CheckoutSuccess(
            (string) CheckoutFacade::get('transaction_id'),
            CheckoutFacade::get('user'),
            $gatewayMessage,
            $authCode
        );

        $this->session->put($this->successName, $data);

        $this->destroy();
    }

    public function success()
    {
        if(! $this->hasSuccess()) {
            return null;
        }

        return $this->session->get($this->successName);
    }

    public function hasSuccess()
    {
        return $this->session->has($this->successName);
    }

    public function redirect($url, $code = 302)
    {
        return abort($code, '', ['Location' => url($url)]);
    }

    public function clearSuccess()
    {
        $this->session->remove($this->successName);
    }

    public function start()
    {
        $this->destroy();
        $this->clearSuccess();
        $this->putSessionSection('basket_signature', '123456abcdef');
        $this->putSessionSection('ip_address', request()->ip());
        $this->setTransactionId();
    }

    public function notify($order)
    {
        $this->events->dispatch('checkout.success', $order);
    }

    public function setOrder($order)
    {
        $this->putSessionSection('order', $order);
    }

    public function getOrder()
    {
        return $this->get('order');
    }

    public function complete($order)
    {
        $this->destroy();
        unset($_SESSION['CheckoutData']);

        // dd($order);
    }

    public function getBillingAddressJson()
    {
        $billingAddress = $this->get('billing_address');

        if(empty($billingAddress)) return null;

        return $billingAddress->toJson();
    }

    public function handleRequest($request)
    {
        if($request->filled('OrderChosenAvailability')) {
            $this->putSessionSection('availability', urldecode($request->OrderChosenAvailability));
        }

        if($request->filled('occasion')) {
            $this->putSessionSection('occasion', $request->occasion);
        }

        if($request->filled('personalised')) {
            $this->putSessionSection('personalisation', $request->personalised);
        }

        if($request->filled('delivery')) {
            $this->putSessionSection('voucher_delivery', $request->delivery);
        }
    }

    public function isVoucherDelivery()
    {
        return $this->get('voucher_delivery') == 'post';
    }

    public function getDetailsData()
    {
        $user = $this->get('user');

        return json_encode([
            'billing_name' => $user->name ?? null,
            'billing_email' => $user->email ?? null,
            'billing_phone' => $user->phone ?? null,
            'pupil_name' => $user->pupil_name ?? null
        ]);
    }

    public function getAddresses()
    {
        $addresses = [];

        if($this->has('pickup_address')) {
            $addresses['pickup_address'] = $this->get('pickup_address');
        }

        if($this->has('delivery_address')) {
            $addresses['delivery_address'] = $this->get('delivery_address');
        }

        return json_encode($addresses);
    }    
}
