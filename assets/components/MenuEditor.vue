<template>
    <div>
        <input type="hidden" v-model="string" :name="name">
        <el-row>
            <el-tree :data="tree"
                     ref="tree"
                     draggable="draggable"
                     default-expand-all="default-expand-all"
                     :props="defaultProps"
                     @node-click="handleNodeClick"
                     node-key="id"
                     empty-text="Нет элементов"
            >
                <span class="custom-tree-node" slot-scope="{ node, data }">
                    <span>{{ node.label }}</span>
                    <span>
                        <el-button
                            class="text-danger"
                            type="text"
                            size="mini"
                            @click="(e) => handleRemoveClick(node, data, e)">
                            Удалить
                        </el-button>
                    </span>
                </span>
            </el-tree>
        </el-row>
        <el-row>
            <el-button size="small" icon="el-icon-plus" class="mt-3" @click="dialogFormVisible = true">Добавить
            </el-button>
        </el-row>
        <el-dialog @cancel="handleFormCancel" @close="handleFormCancel" title="Пункт меню"
                   :visible.sync="dialogFormVisible">
            <el-form :model="form" label-width="160px">
                <el-form-item label="Название пункта">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="Ссылка">
                    <el-input v-model="form.link" autocomplete="off"></el-input>
                </el-form-item>
                <el-input hidden="hidden" v-model="form.id" auto-complete="off"></el-input>
            </el-form>
            <span slot="footer" class="dialog-footer">
                    <el-button @click="handleFormCancel">Отмена</el-button>
                    <el-button type="primary" @click="handleFormSubmit">Готово</el-button>
                </span>
        </el-dialog>
    </div>
</template>

<script>

import {Row, Dialog, Button, Tree, Form, FormItem, Input} from 'element-ui';

export default {
    name: "MenuEditor",
    comments: {
        Row, Dialog, Button, Tree, Form, FormItem, Input
    },
    props: {
        data: {
            type: Array,
            default: []
        },
        name: {
            type: String,
            default: ''
        }
    },
    data: function () {
        return {
            foo: 'bar',
            form: {
                name: null,
                link: null,
                id: null,
            },
            dialogFormVisible: false,
            tree: this.data,
            defaultProps: {
                children: 'children',
                label: 'name'
            },
            lastId: 0,
        }
    },
    mounted() {
        this.findLastId(this.tree);
    },
    methods: {
        handleNodeClick(data) {
            let el = this.findNodeById(this.tree, data.id);
            this.form.id = el.id;
            this.form.name = el.name;
            this.form.link = el.link;
            this.dialogFormVisible = true;
        },

        handleFormSubmit() {
            if (this.form.id === null) {
                this.tree.push({
                    name: this.form.name,
                    link: this.form.link,
                    id: ++this.lastId,
                });
            } else {
                let el = this.findNodeById(this.tree, this.form.id);
                el.name = this.form.name;
                el.link = this.form.link;
            }
            this.dialogFormVisible = false;
            this.form = {
                name: null,
                link: null,
                id: null,
            };
        },

        handleFormCancel() {
            this.form = {
                name: null,
                link: null,
                id: null,
            };
            this.dialogFormVisible = false;
        },

        findLastId(nodes) {
            nodes.forEach(el => {
                if (el.id > this.lastId) {
                    this.lastId = el.id;
                }

                if (el.children) {
                    this.findLastId(el.children)
                }
            })
        },

        findNodeById(nodes, id) {
            function find(el) {
                if (el.id === id) {
                    result = el;
                    return true;
                }
                return Array.isArray(el.children) && el.children.some(find);
            }

            let result;
            nodes.some(find);
            return result
        },

        removeNode(id) {
            function searchAndDestroy(arr){
                let index = arr.findIndex(el => {return el.id === id});
                if (index > -1) {
                    arr.splice(index, 1);
                }

                arr.forEach(el => {
                    if (Array.isArray(el.children)) {
                        searchAndDestroy(el.children);
                    }
                })
            }
            let newData = Array.from(this.tree);
            searchAndDestroy(newData);
            this.tree = newData;
        },

        remove(node, data) {
            //const parent = node.parent;
            //const children = parent.data.children || parent.data;
            //const index = children.findIndex(d => d.id === data.id);
            //children.splice(index, 1);
            this.removeNode(data);
        },

        handleRemoveClick(node, data, event) {
            this.removeNode(data.id);
            event.stopPropagation();
        }
    },

    computed: {
        string: function () {
            return JSON.stringify(this.tree);
        }
    }
}
</script>

<style scoped>
.custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    padding-right: 8px;
}
</style>
