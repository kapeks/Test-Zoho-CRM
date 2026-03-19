<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


// Принимаем стадии от бэкенда
const props = defineProps({
    stages: Array
});

const form = useForm({
    account_name: '',
    website: '',
    phone: '',
    deal_name: '',
    stage: '',
});

const successMessage = ref(null);

const submit = () => {
    successMessage.value = null;

    form.post('/zoho/store', {
        onSuccess: () => {
            successMessage.value = "Запись успешно создана!";
            form.reset();
        },
    });
};
</script>

<template>
    <div class="container">
        <div class="form-card">
            <h2>Создание Сделки и Аккаунта</h2>

            <div v-if="successMessage" class="alert alert-success">
                {{ successMessage }}
            </div>

            <div v-if="form.errors.error" class="alert alert-danger">
                {{ form.errors.error }}
            </div>

            <form @submit.prevent="submit">
                <fieldset>
                    <legend>Данные Аккаунта</legend>

                    <div class="field">
                        <label>Название аккаунта *</label>
                        <input v-model="form.account_name" type="text" :class="{'error-border': form.errors.account_name}">
                        <span class="error-text" v-if="form.errors.account_name">{{ form.errors.account_name }}</span>
                    </div>

                    <div class="field">
                        <label>Веб-сайт</label>
                        <input v-model="form.website" type="text" placeholder="https://example.com" :class="{'error-border': form.errors.website}">
                        <span class="error-text" v-if="form.errors.website">{{ form.errors.website }}</span>
                    </div>

                    <div class="field">
                        <label>Телефон</label>
                        <input
                            v-model="form.phone"
                            type="tel"
                            placeholder="Например: 380671234567"
                            :class="{'error-border': form.errors.phone}"
                        >
                        <span class="error-text" v-if="form.errors.phone">{{ form.errors.phone }}</span>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Данные Сделки</legend>

                    <div class="field">
                        <label>Название сделки *</label>
                        <input v-model="form.deal_name" type="text" :class="{'error-border': form.errors.deal_name}">
                        <span class="error-text" v-if="form.errors.deal_name">{{ form.errors.deal_name }}</span>
                    </div>

                    <div class="field">
                        <label>Стадия сделки *</label>
                        <select v-model="form.stage" :class="{'error-border': form.errors.stage}">
                            <option value="">Выберите стадию...</option>
                            <option v-for="s in stages" :key="s" :value="s">{{ s }}</option>
                        </select>
                        <span class="error-text" v-if="form.errors.stage">{{ form.errors.stage }}</span>
                    </div>
                </fieldset>

                <button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Отправка...' : 'Создать в Zoho' }}
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
.container { display: flex; justify-content: center; padding: 40px; background: #f4f7f6; min-height: 100vh; font-family: sans-serif; }
.form-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
h2 { text-align: center; color: #333; margin-bottom: 25px; }
fieldset { border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 20px; }
legend { font-weight: bold; padding: 0 10px; color: #666; }
.field { margin-bottom: 15px; }
label { display: block; margin-bottom: 5px; font-size: 14px; color: #444; }
input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
.error-border { border-color: #e74c3c; }
.error-text { color: #e74c3c; font-size: 12px; margin-top: 4px; display: block; }
button { width: 100%; padding: 12px; background: #42b883; border: none; color: white; font-weight: bold; border-radius: 4px; cursor: pointer; transition: 0.3s; }
button:disabled { background: #ccc; cursor: not-allowed; }
button:hover:not(:disabled) { background: #3aa876; }
.alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>
