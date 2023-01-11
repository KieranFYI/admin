<template>
    <div class="form-group row">
        <label :for="id" v-if="label !== null" class="col-lg-2 text-lg-right">
            {{ label }}
        </label>
        <div class="input-group col-lg-10 flex-column">
            <div class="form-check" v-for="(text,key,index) in options">
                <input
                    class="form-check-input"
                    type="radio"
                    :id="id + '_' + index"
                    :name="name"
                    :value="key"
                    :checked="key === this.value"
                    :disabled="loading"
                    @change="update(key)"
                />
                <label class="form-check-label" :for="id + '_' + index">{{ text }}</label>
            </div>

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
        label: {
            type: String
        },
        name: {
            type: String,
            required: true
        },
        value: {
            type: String
        },
        placeholder: {
            type: String
        },
        errors: {
            type: Array
        },
        options: {
            type: Object,
            required: true,
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