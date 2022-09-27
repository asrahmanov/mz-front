<template>
    <div>
        <b-overlay spinner-variant="primary" :show="loading">
            <table class="table table-hover text-nowrap">
            <thead>
            <tr>
                <th v-for="field in fields"><a href="javascript:void(0)" class="link-muted" @click="changeOrder(field.name)">{{ field.label }}</a></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in list">
                <td v-for="field in fields">{{ getFieldValue(row, field) }}</td>
                <td class="text-right">
                    <entity-list-actions :entity-id="row.id" :slug="slug" @delete="entityDeletedHandler"></entity-list-actions>
                </td>
            </tr>
            </tbody>
        </table>
        </b-overlay>
        <div class="m-3">
            <b-pagination
                v-model="pagination.page"
                :total-rows="pagination.totalItems"
                :per-page="pagination.itemsPerPage"
                first-number
                last-number
                prev-text="« Назад"
                next-text="Вперед »"
            ></b-pagination>
        </div>
    </div>
</template>

<script>
import {BootstrapVue, BPagination, BOverlay} from 'bootstrap-vue';
import EntityListActions from './EntityListActions';

export default {
    components: {EntityListActions, BootstrapVue, BPagination, BOverlay},
    name: "EntityList",
    props: [
        'slug',
        'fields'
    ],
    data() {
        return {
            loading: true,
            endpoint: '/api/' + this.slug + '.jsonld',
            list: {},
            pagination: {
                itemsPerPage: 10,
                page: 1,
                currentPage: null,
                totalItems: null,
            },
            order: {
                fieldName: this.fields[0].name,
                direction: true,
            },
        }
    },
    mounted() {
        this.updateList();
    },
    methods: {
        updateList() {
            this.loading = true;
            fetch(this.url)
                .then(response => {
                    if (!response.ok) throw Error(response.statusText);
                    return response.json();
                })
                .then(data => {
                    this.loading = false;
                    this.list = data['hydra:member'];
                    this.pagination.totalItems = data['hydra:totalItems'];
                });
        },
        getFieldValue(row, field) {
            if (field.property !== undefined) {
                return row[field.name] ? row[field.name][field.property] : '';
            }
            return row[field.name];
        },
        changeOrder(fieldName) {
            if (this.order.fieldName === fieldName) {
                this.order.direction = !this.order.direction;
            }
            else {
                this.order.fieldName = fieldName;
            }
            this.updateList();
        },
        entityDeletedHandler(id) {
            this.updateList();
        },
    },
    computed: {
        url() {
            let uRLSearchParams = new URLSearchParams({
                itemsPerPage: this.pagination.itemsPerPage,
                page: this.pagination.page
            });
            uRLSearchParams.append('order['+ this.order.fieldName + ']', this.order.direction ? 'desc' : 'asc')

            return this.endpoint + '?' + uRLSearchParams;
        },
        currentPage() {
            return this.pagination.page;
        }
    },
    watch: {
        currentPage(){
            this.updateList();
        }
    }
}
</script>

<style scoped>

</style>
