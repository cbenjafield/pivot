<template>
    <div class="editor-wrapper p-3 absolute bottom-0 left-0 right-0 border-t border-gray-200">
        <textarea name="content" ref="editor" :value="value"></textarea>
    </div>
</template>
<style lang="scss">
.medium-editor-element {
    @apply absolute h-full w-full top-0 left-0 p-6;

    &:focus {
        @apply outline-none;
    }

    a {
        color: theme('colors.indigo.600');
    }

    h2, h3, h4, h5, h6 {
        font-weight: 700;
        @apply my-4;

        &:first-child {
            @apply mt-0;
        }
    }

    h2 {
        font-size: theme('fontSize.2xl')
    }

    p {
        @apply mb-3 leading-relaxed;

        &:last-of-type {
            @apply mb-0;
        }
    }

    .row {
        @apply border-t-2 border-b-2 border-gray-200 border-dashed my-4;

        .column {
            position: relative;

            &:before {
                border: 1px dotted theme('colors.gray.200');
                position: absolute;
                top: 0;
                left: theme('padding.5');
                right: theme('padding.5');
                bottom: 0;
                content: " ";
                display: block;
            }
        }

    }
}

.editor {
    &-wrapper {
        top: theme('height.32');

        .medium-editor-placeholder:after {
            color: theme('colors.indigo.400');
        }
    }
}
</style>
<script>
export default {
    props: [
        'value'
    ],
    data() {
        return {
            content: null,
            editor: null,
            editorElement: null,
        };
    },
    mounted() {
        this.$nextTick(() => {
            this.initEditor();
        });
    },
    methods: {
        initEditor() {
            this.editorElement = this.$refs.editor;

            this.editor = new MediumEditor(this.editorElement, {
                autoLink: true,
                toolbar: {
                    allowMultiParagraphSelection: true
                },
                paste: {
                    forcePlainText: false,
                    cleanPastedHTML: false
                }
            });

            document.querySelectorAll('.medium-editor-element [style]').forEach(element => {
                element.removeAttribute('style');
            });

            this.editor.subscribe('editableInput', (event, editorElement) => {
                this.editor.saveSelection();
                this.updateEditorContent(this.editor.getContent());
            });

            this.editor.subscribe('editableClick', () => {
                this.editor.saveSelection();
            });

            this.editor.subscribe('focus', () => {
                setTimeout(this.editor.restoreSelection.bind(this.editor), 1);
            });
        },
        updateEditorContent(value) {
            this.$emit('input', value);
        }
    }
}
</script>