<template>
    <div>
        <a :href="'/admin/' + slug + '/edit/' + entityId" class="btn btn-sm btn-outline-info">Редактировать</a>
        <input :id="deleteButtonId" type="submit" value="Удалить" class="btn btn-sm btn-outline-danger ml-2">
        <b-popover triggers="click" ref="confirmPopover" :target="deleteButtonId">
            <div class="pb-2">Вы действительно хотите удалить этот элемент?</div>
            <button @click="deleteElement" class="btn btn-sm btn-danger">Удалить</button>
            <button @click="closeConfirmPopover" class="btn btn-sm btn-secondary">Отмена</button>
        </b-popover>
    </div>
</template>

<script>
import {BPopover} from 'bootstrap-vue';

export default {
    name: "EntityListActions",
    components: {BPopover},
    props: {
        slug: String,
        entityId: {},
        api: {
            type: Boolean,
            default: false,
        }
    },
    methods: {
        closeConfirmPopover() {
            this.$refs.confirmPopover.$emit('close');
        },
        deleteElement() {
            this.closeConfirmPopover();
            let path = [this.basePath, this.slug, this.entityId].join('/');
            console.log(path);
            fetch(path, {
                method: 'DELETE',
            })
            .then(r => {
                this.$emit('delete', this.entityId);
            });
        }
    },
    computed: {
        deleteButtonId() {
            return 'delete-' + this.slug + '-' + this.entityId;
        },

        basePath() {
            return '/api';
        }
    },
}
</script>

<style scoped>

</style>
