<template>
    <div class="container justify-content-center" v-if="hasSources">
        <div class="form-group row" style="width: 500px; margin: auto;padding-top:8px;">
            <div class="col-sm-2 col-form-label">
                Телефон:
            </div>
            <div class="col-sm-8">
                <input v-model="phone" class="form-control">
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-default btn-outline-primary"
                        v-on:click="searchData" :disabled="phone.length < 1">
                    Поиск
                </button>
            </div>
        </div>
        <div class="table-responsive" v-if="results.length > 0" style="padding-top: 8px;">
            <table class="table table-striped table-hover table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Телефон</th>
                    <th>Почта</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(result, res_id) in results">
                    <td>{{res_id + 1}}</td>
                    <td>{{result.name}}</td>
                    <td>{{result.phone}}</td>
                    <td>{{result.email}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ContactsFind",
        computed: {
            hasSources: function () {
                return !!(window.sources);
            },
        },
        data: function () {
            return {
                phone: '',
                results: [],
            }
        },
        methods: {
            searchData: function() {
                let instance = this;
                this.apiRequest({
                    url: '/api/contacts',
                    method: 'get',
                    data: {
                        phone: this.phone,
                    },
                    success: function (response) {
                        if (response && Array.isArray(response) && response.length > 0) {
                            instance.results = response;
                        } else {
                            alert('Ничего не найдено')
                        }
                    },
                    error: function () {
                        alert('Ошибка поиска');
                    }
                })
            },
            apiRequest: async function (params) {
                let instance = this;
                if (!this.apiKey) {
                    await $.ajax({
                        method: 'post',
                        url: '/oauth/token',
                        data: {
                            client_id: 1,
                            grant_type: 'client_credentials',
                            client_secret: 'CQ1WXdq6lDx4pqhMnEWN7zvmyszFJsTXEKSlf3X4',
                            scope: ''
                        },
                        success: function (response) {
                            if (response && response.access_token && response.access_token.length > 0) {
                                instance.apiKey = response.access_token;
                            } else {
                                alert('Ошибка получения ключа API')
                            }
                        },
                        error: function () {
                            alert('Ошибка получения ключа API')
                        }
                    });
                    if (!this.apiKey) {
                        return false;
                    }
                }
                let default_params = {
                    dataType: 'json',
                    headers: {
                        'Authorization': 'Bearer ' + this.apiKey
                    }
                };
                $.ajax(Object.assign(params, default_params));
            }
        }
    }
</script>

<style scoped>

</style>
