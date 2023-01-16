<template>
    <div class="card">
        <div class="card-header" v-if="header && !small">
            <h1 class="card-title">{{ title }}</h1>
            <div class="card-tools d-flex">
                <slot></slot>
                <div class="ml-2" v-if="search">
                    <input-text
                        name="search"
                        size="sm"
                        placeholder="Search"
                        @updated="doSearch"
                    />
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table :class="{
                    table: true,
                    'table-sm': small,
                    'table-stripped': stripped,
                    'table-bordered': bordered,
                    'table-hover': hover
                }">
                <thead v-if="thead && !small">
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
                <tbody v-if="rows !== undefined">
                <tr v-if="rows === null">
                    <td :colspan="Object.keys(columns).length + 1">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr v-else-if="rows.length === 0">
                    <td :colspan="Object.keys(columns).length + 1" class="text-center">
                        No data available
                    </td>
                </tr>
                <tr v-for="row in rows" v-else>
                    <td v-for="(label, column) in columns">
                        <template
                            v-if="typeof label === 'object' && typeof label.type === 'string' && label.type === 'date'">
                            {{ this.formatDate(this.getProp(row, column, 'Unknown')) }}
                        </template>
                        <template v-else>
                            {{ this.getProp(row, column, 'Unknown') }}
                        </template>
                    </td>
                    <td class="text-right">
                        <div class="d-flex justify-content-center" v-if="loading">
                            <div class="spinner-border spinner-border-sm text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <template v-else v-for="action in row.actions" v-if="row.actions">
                            <button type="button" :class="action.class" @click="action.click(row)"
                                    v-if="action.click !== undefined">
                                <i :class="action.icon"></i>
                            </button>
                            <a :href="action.url" class="text-primary" v-else>
                                <i :class="action.icon"></i>
                            </a>
                        </template>
                    </td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr v-if="data.data === null">
                    <td :colspan="Object.keys(columns).length + 1">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr v-else-if="data.data.length === 0">
                    <td :colspan="Object.keys(columns).length + 1" class="text-center">
                        No data available
                    </td>
                </tr>
                <tr v-for="row in data.data" v-else>

                    <td v-if="actionLocation == 'start'">
                        <div class="d-flex justify-content-center" v-if="loading">
                            <div class="spinner-border spinner-border-sm text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <template v-else v-for="action in row.actions" v-if="row.actions">
                            <button type="button" :class="action.class" @click="action.click(row)"
                                    v-if="action.click !== undefined">
                                <i :class="action.icon"></i>
                            </button>
                            <a :href="action.url" class="text-primary" v-else>
                                <i :class="action.icon"></i>
                            </a>
                        </template>
                    </td>

                    <td v-for="(label, column) in columns">
                        <template
                            v-if="typeof label === 'object' && typeof label.type === 'string' && label.type === 'date'">
                            {{ this.formatDate(this.getProp(row, column, 'Unknown')) }}
                        </template>
                        <template v-else>
                            {{ this.getProp(row, column, 'Unknown') }}
                        </template>
                    </td>

                    <td class="text-right" v-if="actionLocation == 'end'">
                        <div class="d-flex justify-content-center" v-if="loading">
                            <div class="spinner-border spinner-border-sm text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <template v-else v-for="action in row.actions" v-if="row.actions">
                            <button type="button" :class="action.class" @click="action.click(row)"
                                    v-if="action.click !== undefined">
                                <i :class="action.icon"></i>
                            </button>
                            <a :href="action.url" class="text-primary" v-else>
                                <i :class="action.icon"></i>
                            </a>
                        </template>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer" v-if="footer && !small">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="spinner-border spinner-border-sm text-secondary" role="status" v-if="loading">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="text-muted" v-else>
                        <template v-if="rows !== undefined">
                            Showing {{ rows.total }} entries
                        </template>
                        <template v-else-if="data !== undefined">
                            <template v-if="data.from === 1 && data.to === data.total">
                                Showing {{ data.length }} entries
                            </template>
                            <template v-else>
                                Showing {{ data.from }} to {{ data.to }} of {{ data.total }} entries
                            </template>
                        </template>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                    <ul class="pagination pagination-sm m-0">
                        <template v-for="link in data.links" v-if="data !== undefined">
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
export default {
    emits: [
        'filter'
    ],
    props: {
        title: {
            type: String
        },
        data: {
            type: Object,
        },
        rows: {
            type: Array
        },
        columns: {
            type: Object,
            required: true
        },
        loading: {
            type: Boolean
        },
        search: {
            type: Boolean,
            default: true
        },
        header: {
            type: Boolean,
            default: true
        },
        thead: {
            type: Boolean,
            default: true
        },
        footer: {
            type: Boolean,
            default: true
        },
        small: {
            type: Boolean,
            default: false,
        },
        stripped: {
            type: Boolean,
            default: false
        },
        bordered: {
            type: Boolean,
            default: false
        },
        hover: {
            type: Boolean,
            default: true
        },
        actionLocation: {
            type: String,
            default: 'end'
        }
    },
    data() {
        return {
            searchText: null
        };
    },
    methods: {
        doSearch(key, value) {
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
        formatDate(date) {
            return new Date(date).toLocaleString('sv');
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