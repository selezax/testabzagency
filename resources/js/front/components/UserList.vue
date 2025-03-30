<template>
    <div class="container my-5">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ $t('field.nickname') }}</th>
                <th>{{ $t('field.phone') }}</th>
                <th>{{ $t('field.image') }}</th>
                <th>{{ $t('field.created_at') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.phone }}</td>
                <td><img :src="user.photo" class="img-thumbnail"/></td>
                <td>{{ formatDate(user.registration_timestamp) }}</td>
                <td>
                    <button
                        class="btn btn-secondary btn-sm"
                        @click="showUserDetails(user.id)"
                        data-bs-toggle="modal"
                        data-bs-target="#userModal"
                    >
                        <i class="fa fa-info-circle"></i> {{ $t('more') }}
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <nav aria-label="User list pagination" v-if="totalPages > 1">
            <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <button class="page-link" @click="fetchUsers(currentPage - 1)" :disabled="currentPage === 1">
                        {{ $t('Previous') }}
                    </button>
                </li>
                <li class="page-item" v-for="page in paginationRange" :key="page" :class="{ active: currentPage === page }">
                    <button class="page-link" @click="fetchUsers(page)">
                        {{ page }}
                    </button>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                    <button class="page-link" @click="fetchUsers(currentPage + 1)" :disabled="currentPage === totalPages">
                        {{ $t('Next') }}
                    </button>
                </li>
            </ul>
        </nav>

        <!-- Модальное окно -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">
                            <i class="fas fa-user text-primary"></i> {{ $t('User Details') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" v-if="selectedUser">
                        <p><strong>{{ $t('field.id') }}:</strong> {{ selectedUser.id }}</p>
                        <p><strong>{{ $t('field.name') }}:</strong> {{ selectedUser.name }}</p>
                        <p><strong>{{ $t('field.email') }}:</strong> {{ selectedUser.email }}</p>
                        <p><strong>{{ $t('field.phone') }}:</strong> {{ selectedUser.phone }}</p>
                        <p><strong>{{ $t('field.position') }}:</strong> {{ selectedUser.position }}</p>
                        <p><strong>{{ $t('field.photo') }}:</strong></p>
                        <img :src="selectedUser.photo" alt="User Photo" class="img-thumbnail" />
                    </div>
                    <div class="modal-body" v-else-if="loading">
                        <p>Loading...</p>
                    </div>
                    <div class="modal-body" v-else>
                        <p class="text-danger">Failed to load user details.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $t('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'UserList',
    props: {
        urlUsers: {
            type: String,
            required: true,
        },
        urlUser: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            users: [],
            selectedUser: null,
            loading: false,

            currentPage: 1,
            totalPages: 1,
            count: 6,
            totalUsers: 0,
        };
    },
    mounted() {
        this.fetchUsers();
    },
    computed: {
        paginationRange() {
            const range = [];
            const maxPagesToShow = 5;
            let start = Math.max(1, this.currentPage - Math.floor(maxPagesToShow / 2));
            let end = Math.min(this.totalPages, start + maxPagesToShow - 1);

            if (end - start + 1 < maxPagesToShow) {
                start = Math.max(1, end - maxPagesToShow + 1);
            }

            for (let i = start; i <= end; i++) {
                range.push(i);
            }
            return range;
        },
    },
    methods: {
        formatDate(value) {
            if (!value) return 'N/A';
            const date = new Date(value * 1000);
            return date.toLocaleString() || 'Invalid Date';
        },
        async fetchUsers(page) {
            try {
                this.loading = true;
                const response = await axios.get(this.urlUsers, {
                    params: { page: page, count: this.count },
                });
                if (response.data.success) {
                    this.users = response.data.users;
                    this.currentPage = response.data.page;
                    this.totalPages = response.data.total_pages;
                    this.totalUsers = response.data.total_users;
                    console.log('Fetched users:', this.users); // Отладка
                }
            } catch (error) {
                console.error('Failed to fetch users:', error);
            } finally {
                this.loading = false;
            }
        },

        async showUserDetails(userId) {
            this.loading = true;
            this.selectedUser = null;

            try {
                const url = this.urlUser.replace(':id', userId);
                const response = await axios.get(url);
                if (response.data.success) {
                    this.selectedUser = response.data.user;
                    console.log('Selected user:', this.selectedUser); // Отладка
                }
            } catch (error) {
                console.error('Failed to fetch user details:', error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.table th,
.table td {
    vertical-align: middle;
}
</style>
