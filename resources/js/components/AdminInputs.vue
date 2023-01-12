<template>
    <template v-for="(input,key,index) in inputs">

        <input-checkbox v-if="input.type === 'checkbox'"
                        :label="input.label"
                        :name="input.name"
                        :value="getValue(input.name)"
                        :errors="getError(input.name)"
                        :loading="loading"
                        @updated="updateData"
        />

        <input-checkbox-multi v-else-if="input.type === 'checkbox_multi'"
                              :label="input.label"
                              :name="input.name"
                              :values="getValue(input.name)"
                              :errors="getError(input.name)"
                              :options="input.options"
                              :loading="loading"
                              @updated="updateData"
        />

        <input-radio v-else-if="input.type === 'radio'"
                     :label="input.label"
                     :name="input.name"
                     :value="getValue(input.name)"
                     :errors="getError(input.name)"
                     :options="input.options"
                     :loading="loading"
                     @updated="updateData"
        />

        <input-text v-else
                    :type="input.type"
                    :label="input.label"
                    :name="input.name"
                    :value="getValue(input.name)"
                    :errors="getError(input.name)"
                    :size="size"
                    :loading="loading"
                    @updated="updateData"
        />

        <hr v-if="index != Object.keys(inputs).length - 1"/>
    </template>
</template>

<script>
import InputCheckbox from "./Inputs/InputCheckbox";
import InputCheckboxMulti from "./Inputs/InputCheckboxMulti";
import InputRadio from "./Inputs/InputRadio";
import InputText from "./Inputs/InputText";

export default {
    components: {
        InputText, InputCheckbox, InputRadio, InputCheckboxMulti
    },
    emits: [
        'updated'
    ],
    props: {
        inputs: {
            type: Array,
            required: true
        },
        values: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            required: true
        },
        size: {
            type: String,
        },
        loading: {
            type: Boolean
        }
    },
    computed: {
        _values() {
            return this.values;
        }
    },
    methods: {
        updateData(key, value) {
            this._values[key] = value;
            this.$emit('updated', this._values, key, name);
        },
        getValue(name) {
            if (this.values[name] === undefined) {
                return undefined;
            }
            return this.values[name];
        },
        getError(name) {
            if (this.errors[name] === undefined) {
                return [];
            }
            return this.errors[name];
        }
    }
}
</script>

<style scoped>

</style>