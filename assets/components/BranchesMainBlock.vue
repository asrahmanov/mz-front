<template>
    <div class="row">
        <input type="hidden" :name="fieldName"></input>
        <div class="col form-group">
            <el-select v-model="value">
                <el-option v-for="option in options" :value="option.value" :label="option.text"></el-option>
            </el-select>
        </div>
        <div class="col form-group">
            {{ value }}
        </div>
    </div>
</template>

<script>
import  ElOption from 'element-ui/lib/option';
import  ElSelect from 'element-ui/lib/select';

export default {
    components: {ElSelect, ElOption},
    name: "BranchesMainBlock",
    props: [
        'fieldName',
    ],
    data: () => {
        return {
            options: [
                { text: 'Один', value: 'А' },
                { text: 'Два', value: 'Б' },
                { text: 'Три', value: 'В' }
            ],
            value: null,
        };
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
