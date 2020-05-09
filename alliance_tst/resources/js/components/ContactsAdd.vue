<template>
    <div class="container justify-content-center" v-if="hasSources">
        <div class="form-row" style="width: 500px; margin: auto;">
            <div class="col">
                <label for="source_id">Клиент</label>
                <select class="form-control" id="source_id" name="source_id" v-on:change="clearContacts" v-model="source_id">
                    <option v-for="source in getSources" v-bind:value="source.source_id">{{source.name}}</option>
                </select>
            </div>
        </div>
        <div class="form-row" v-for="(contact, cont_id) in contacts">
            <div class="col" v-for="(name, field) in fields">
                <label v-bind:for="'source_'+field">{{name}}</label>
                <input v-bind:id="'source_'+field" v-bind:name="'source_'+field" class="form-control" v-model="contacts[cont_id][field]">

            </div>
            <div class="col-sm-1" style="text-align: right;">
                <label>&nbsp;</label><br>
                <button type="button" class="btn btn-outline-primary" v-on:click="removeContact(cont_id)">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
        <div class="form-row">
            <div class="col" style="text-align: left;padding-top:8px;">
                <button type="button" class="btn btn-default btn-outline-primary col-sm-5"
                        v-on:click="saveData" :disabled="contacts.length < 1">
                    Сохранить данные
                </button>
            </div>
            <div class="col" style="text-align: right;padding-top:8px;">
                <span class="col-sm-2 col-form-label" style="text-align: right;">Добавить контакт</span>
                <button type="button" class="btn btn-default btn-outline-primary col-sm-2" style="font-size: 28px;line-height: 1.3;padding: unset;"
                v-on:click="addContact">
                    +
                </button>
            </div>
        </div>
    </div>
    <div v-else>
        Нет ни одного клиента
    </div>
</template>

<script>
    export default {
        name: "ContactsAdd",
        data: function () {
            return {
                fields: {
                    'name': 'Имя',
                    'phone': 'Телефон',
                    'email': 'Почта'
                },
                source_id: undefined,
                contacts: [
                    {
                        'name': '',
                        'phone': '',
                        'email': ''
                    }
                ],
                validator: {
                    'phone':  /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/,
                    'email': /.+@.+\..+/
                },
                apiKey: ''
            }
        },
        computed: {
            hasSources: function () {
                return !!(window.sources);
            },
            getSources: function () {
                return window.sources;
            }
        },s
        methods: {
            clearContacts: function () {
                this.contacts = [
                    {
                        'name': '',
                        'phone': '',
                        'email': ''
                    }
                ]
            },
            addContact: function () {
                this.contacts.push({
                    'name': '',
                    'phone': '',
                    'email': ''
                });
            },
            removeContact: function (cont_id) {
                this.contacts.splice(cont_id, 1);
            },
            saveData: function () {
                if (!this.validateContacts()) {
                    alert("Заполнены не все данные");
                } else {
                    let instance = this;
                    this.apiRequest({
                        url: '/api/contacts',
                        method: 'post',
                        data: {
                            source_id: this.source_id,
                            items: this.contacts
                        },
                        success: function (response) {
                            if (response > 0) {
                                alert('Контакты добавлены');
                                instance.clearContacts();
                            } else {
                                alert('Произошла ошибка добавления контактов')
                            }
                        },
                        error: function () {
                            alert('Произошла ошибка добавления контактов')
                        }
                    });
                }
            },
            validateContacts: function () {
                let instance = this;
                let result = true;
                this.contacts.forEach(function (element) {
                    for(let prop in element) {
                        if (element[prop] === '' || (instance.validator[prop] && instance.validator[prop].exec(element[prop]) === null)) {
                            result = false;
                            break;
                        }
                    }
                });

                return result;
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
