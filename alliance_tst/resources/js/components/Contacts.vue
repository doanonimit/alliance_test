<template>
    <div class="container">
        <ul class="nav nav-pills justify-content-center">
            <li
                v-for="(name, action) in actions"
                v-bind:key="action"
                v-bind:class="{ active: currentAction === action }"
                v-on:click="currentAction = action"
                class="nav-item"
            >
                <a class="nav-link"
                   v-bind:class="{ active: currentAction === action }"
                   href="#">{{name}}</a>
            </li>
        </ul>
        <div class="row justify-content-center" v-if="currentAction">
            <component v-bind:is="currentActionComponent"></component>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Contacts",
        data: function () {
            return {
                actions: {add:"Добавить контакты", find:"Найти контакты"},
                currentAction: ''
            }
        },
        computed: {
            currentActionComponent: function() {
                return "action-" + this.currentAction.toLowerCase();
            },
        }
    }
</script>

<style scoped>

</style>
