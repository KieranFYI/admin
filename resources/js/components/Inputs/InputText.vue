<template>
    <div class="form-group row">
        <label :for="id" v-if="label !== null" class="col-lg-2 text-lg-right">
            {{ label }}
        </label>
        <div class="input-group col-lg-10">

            <textarea v-if="type === 'textarea'"
                      :class="classes"
                      :id="id"
                      :placeholder="placeholder"
                      :disabled="loading"
                      @input="update($event.target.value)"
            >{{ value }}</textarea>

            <input v-else
                   :type="type ?? 'text'"
                   :class="classes"
                   :id="id"
                   :placeholder="placeholder"
                   :value="value"
                   :disabled="loading"
                   @input="update($event.target.value)"
            />

            <span class="invalid-feedback d-block" role="alert" v-for="error in errors">
                {{ error }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    emits: [
        'updated'
    ],
    props: {
        type: {
            type: String
        },
        label: {
            type: String
        },
        name: {
            type: String,
            required: true
        },
        value: null,
        placeholder: {
            type: String
        },
        size: {
            type: String,
        },
        errors: {
            type: Array
        },
        loading: {
            type: Boolean
        }
    },
    data() {
        return {
            id: null,
        };
    },
    computed: {
        classes() {
            return {
                'form-control': true,
                'form-control-sm': this.size === 'sm',
                'form-control-lg': this.size === 'lg'
            }
        }
    },
    methods: {
        update(value) {
            this.$emit('updated', this.name, value);
        }
    },
    created() {
        this.id = Math.random().toString(36).replace(/[^a-z]+/g, '');
    }
}
</script>