<template>
    <div>
        <tui-editor @change="change" ref="textContent" :initialValue="content" :options="editorOptions" height="250px" initialEditType="wysiwyg" />
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
import { Editor } from '@toast-ui/vue-editor'

export default {
    props: [
        'block'
    ],
    components: {
        'tui-editor': Editor
    },
    data() {
        return {
            editorOptions: {
                hideModeSwitch: true
            },
            content: 'Enter text here...'
        };
    },
    mounted() {
        this.setContent();
    },
    methods: {
        remove() {
            this.$parent.$parent.removeBlock(this.block.id);
        },
        json() {
            return {
                id: this.block.id,
                type: this.block.type,
                content: this.content
            };
        },
        getMarkdown() {
            return this.$refs.textContent.invoke('getMarkdown');
        },
        change() {
            this.content = this.getMarkdown();
            this.$forceUpdate();
        },
        setContent() {
            if(this.block.content) {
                this.content = this.block.content;
                this.$refs.textContent.invoke('setMarkdown', this.content);
            }
        }
    }
}
</script>