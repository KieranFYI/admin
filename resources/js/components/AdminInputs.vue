<template>
    <template v-for="(input,key,index) in inputs">

        <input-checkbox v-if="input.type === 'checkbox'"
                        :label="input.label"
                        :name="input.name"
                        :value="this.getProp(this.values, input.name)"
                        :errors="this.getProp(this.errors, input.name)"
                        :loading="loading"
                        @updated="updateData"
        />

        <input-checkbox-multi v-else-if="input.type === 'checkbox_multi'"
                              :label="input.label"
                              :name="input.name"
                              :values="this.getProp(this.values, input.name)"
                              :errors="this.getProp(this.errors, input.name)"
                              :options="input.options"
                              :loading="loading"
                              @updated="updateData"
        />

        <input-radio v-else-if="input.type === 'radio'"
                     :label="input.label"
                     :name="input.name"
                     :value="this.getProp(this.values, input.name)"
                     :errors="this.getProp(this.errors, input.name)"
                     :options="input.options"
                     :loading="loading"
                     @updated="updateData"
        />

        <input-text v-else
                    :type="input.type"
                    :label="input.label"
                    :name="input.name"
                    :value="this.getProp(this.values, input.name)"
                    :errors="this.getProp(this.errors, input.name)"
                    :size="size"
                    :loading="loading"
                    @updated="updateData"
        />

        <hr v-if="index != Object.keys(inputs).length - 1"/>
    </template>
</template>

<script>
export default {
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
        getProp(object, keys, defaultVal) {
            keys = Array.isArray(keys) ? keys : keys.split('.');
            object = object[keys[0]];
            if (object && keys.length > 1) {
                return this.getProp(object, keys.slice(1), defaultVal);
            }
            return object === undefined ? defaultVal : object;
        }
    }
}
</script>

<style scoped>

</style>