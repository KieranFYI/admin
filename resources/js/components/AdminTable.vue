<template>
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">{{ title }}</h1>
            <div class="card-tools">
                <input-text
                    name="search"
                    size="sm"
                    placeholder="Search"
                    @updated="search"
                />
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-striped text-nowrap">
                <thead>
                <tr>
                    <th v-for="(label, column) in columns">
                        <template v-if="typeof label === 'object' && typeof label.label === 'string'">
                            {{ label.label }}
                        </template>
                        <template v-else>
                            {{ label }}
                        </template>
                    </th>
                    <th style="width: 100px" class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="data.data === null">
                    <td colspan="5">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr v-for="row in data.data" v-else>

                    <td v-for="(label, column) in columns">
                        <template
                            v-if="typeof label === 'object' && typeof label.type === 'string' && label.type === 'date'">
                            {{ this.formatDate(row[column]) }}
                        </template>
                        <template v-else>
                            {{ row[column] }}
                        </template>
                    </td>
                    <td class="text-right">
                        <div class="d-flex justify-content-center" v-if="loading">
                            <div class="spinner-border spinner-border-sm text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <template v-else v-for="action in row.actions" v-if="row.actions">
                            <a :href="action.url" class="text-primary">
                                <i :class="action.icon"></i>
                            </a>
                        </template>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="spinner-border spinner-border-sm text-secondary" role="status" v-if="loading">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="text-muted" v-else>
                        <template v-if="data.from === 1 && data.to === data.total">
                            Showing {{ data.total }} entries
                        </template>
                        <template v-else>
                            Showing {{ data.from }} to {{ data.to }} of {{ data.total }} entries
                        </template>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                    <ul class="pagination pagination-sm m-0">
                        <template v-for="link in data.links">
                            <li :class="{'page-item': true, disabled: link.active || link.url === null}"
                                style="cursor: pointer"
                                @click="page(link)">
                                <div class="page-link" v-html="link.label">
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InputText from "./Inputs/InputText";

export default {
    components: {
        InputText
    },
    emits: [
        'filter'
    ],
    props: {
        title: {
            type: String,
            required: true
        },
        data: {
            type: Object,
            required: true
        },
        columns: {
            type: Object,
            required: true
        },
        loading: {
            type: Boolean
        }
    },
    data() {
        return {
            searchText: null
        };
    },
    methods: {
        search(key, value) {
            this.searchText = value;
            this.$emit('filter', {
                search: this.searchText,
                page: 1,
            });
        },
        page(item) {
            if (item.active || item.url === null) {
                return;
            }

            let url = new URL(item.url);
            this.$emit('filter', {
                search: this.searchText,
                page: parseInt(url.searchParams.get('page')),
            });
        },
        formatDate: function (date) {
            return new Date(date).toLocaleString('sv');
        },
    }
}
</script>