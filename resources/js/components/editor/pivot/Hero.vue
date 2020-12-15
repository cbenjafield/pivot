<template>
    <div>
        <div class="shadow">
            <div class="hero flex items-center text-white w-full py-16 bg-gray-900">
                <div class="container px-6">
                    <div class="mb-4">
                        <input type="text" v-model="headingText" class="w-full text-4xl font-bold text-white bg-transparent border-b border-gray-200 outline-none">
                    </div>
                    <div>
                        <div class="mb-3 flex items-start" v-for="(bullet, index) in bullets" :key="'bullet-' + (index + 1)">
                            <i class="far fa-long-arrow-right mr-2 mt-1"></i>
                            <div class="flex-1 mr-2">
                                <textarea v-model="bullets[index]" class="bg-transparent border-b border-gray-400 w-1/2 outline-none" rows="2"></textarea>
                            </div>
                            <button class="text-base text-red-500" type="button" @click.prevent="removeBullet(index)">
                                <i class="far fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="text-gray-400 text-sm mt-2 focus:outline-none" @click.prevent="addBullet">
                        <i class="far fa-plus mr-1"></i> Add bullet point
                    </button>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-6 px-3 pb-3">
                <div class="grid grid-cols-3 gap-2">
                    <label class="font-semibold text-gray-600 flex items-center">Button Text</label>
                    <input type="text" class="form-input transition duration-150 ease-in-out col-span-2" placeholder="Button Text" v-model="buttonText">
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <label class="font-semibold text-gray-600 flex items-center">Button Href</label>
                    <input type="text" class="form-input transition duration-150 ease-in-out col-span-2" placeholder="Button Href" v-model="buttonHref">
                </div>
            </div>
        </div>
        <div class="mt-2 flex items-center text-sm">
            <div class="flex-1 mr-6">

            </div>
            <div>
                <button type="button" class="text-gray-500" @click.prevent="remove">
                    <i class="far fa-times mr-1"></i> Remove
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'block'
    ],
    data() {
        return {
            headingText: 'Enter Heading 1 Here...',
            bullets: [],
            classNames: null,
            backgroundImage: null,
            buttonHref: null,
            buttonText: null,
        }
    },
    mounted() {
        this.setContent();
    },
    methods: {
        addBullet() {
            let nextCount = this.bullets.length + 1;
            this.bullets.push(`Bullet point ${nextCount}`);
        },
        removeBullet(index) {
            this.bullets.splice(index, 1);
        },
        remove() {
            this.$parent.$parent.removeBlock(this.block.id);
        },
        json() {
            return {
                id: this.block.id,
                headingText: this.headingText,
                type: 'pivot-hero',
                bullets: this.bullets,
                classNames: this.classNames,
                backgroundImage: this.backgroundImage,
                buttonText: this.buttonText,
                buttonHref: this.buttonHref,
            };
        },
        setContent() {
            if(!this.block.content) return false;

            this.headingText = this.block.content.headingText;
            this.backgroundImage = this.block.content.backgroundImage;
            this.bullets = this.block.content.bullets;
            this.classNames = this.block.content.classNames;
            this.buttonText = this.block.content.buttonText;
            this.buttonHref = this.block.content.buttonHref;
        }
    }
}
</script>