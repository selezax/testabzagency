<template>
    <div class="container my-5">
        <div class="row gx-2">
            <div class="col-12 justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
                    <span class="fa fa-user-plus"></span> {{ words.adduser }}
                </button>
            </div>
        </div>

        <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addUserLabel">
                            <span class="fa fa-user-plus text-success"></span> {{ words.adduser }}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form @submit.prevent="submitForm" role="form">

                        <div class="modal-body">
                            <slot name="form-fields"></slot>

                            <div v-if="message" class="alert"
                                 :class="{ 'alert-success': success, 'alert-danger': !success }">
                                {{ message }}
                            </div>

                        </div>

                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-12 justify-content-end">
                                    <button class="btn btn-success" type="submit" :disabled="isSubmitting">
                                        <i class="fa fa-send"></i> {{ words.send }}
                                    </button>
                                    <button class="btn btn-danger ms-2" type="reset" @click="resetForm"
                                            :disabled="isSubmitting"  data-bs-dismiss="modal">
                                        <i class="fa fa-close"></i> {{ words.reset }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "UserAdd",
    props: {
        getToken: {
            type: String,
            required: true,
        },
        urlAddUser: {
            type: String,
            required: true,
        },
        words: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            token: null,
            isSubmitting: false,
            message: '',
            success: false,
        };
    },

    methods: {
        async fetchToken() {
            try {
                const response = await axios.get(this.getToken);
                if (response.data.token) {
                    this.token = response.data.token;
                } else {
                    throw new Error('Token not received');
                }
            } catch (error) {
                throw new Error('Failed to fetch token: ' + (error.response?.data?.message || error.message));
            }
        },

        async submitForm() {
            this.isSubmitting = true;
            this.message = '';
            this.success = false;

            try {
                // 1.
                if (!this.token) {
                    await this.fetchToken();
                }

                // 2.
                const form = this.$el.querySelector('form');
                const formData = new FormData(form);

                // 3.
                const response = await axios.post(this.urlAddUser, formData, {
                    headers: {
                        'Token': this.token,
                        'Content-Type': 'multipart/form-data',
                    },
                });

                if (response.data.success) {
                    console.log('response', response.data);
                    this.message = response.data.message || 'User successfully registered!';
                    this.success = true;
                    this.resetForm();
                }
            } catch (error) {
                console.log(error);
                this.success = false;
                const errorMessage = error.response?.data?.message || 'An error occurred';
                this.message = errorMessage;

                if (error.response?.status === 422 && error.response.data.fails) {
                    const fails = error.response.data.fails;
                    this.message += ': ' + Object.values(fails).flat().join('<br/>');
                }
            } finally {
                this.isSubmitting = false;
            }
        },

        resetForm() {
            const form = this.$el.querySelector('form');
            form.reset();
            this.token = null;
        },
    },
}

/*
<div class="row">
                                <div class="col-12">
                                    @if ($errors->any())
                                    <div class="alert alert-danger my-5">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
* */
</script>

