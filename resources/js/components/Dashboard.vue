<template>
    <v-container class="mt-5">
      <v-row justify="space-between" align="center">
        <h1>Users Dashboard</h1>
        <v-btn color="primary" dark @click="openDialog">Add User</v-btn>
      </v-row>

      <v-card class="mt-3">
        <v-card-title>
          <v-text-field
            v-model="search"
            label="Search users..."
            class="ml-auto"
            hide-details
            clearable
          />
        </v-card-title>

        <v-data-table
          :headers="headers"
          :items="users"
          :search="search"
          class="elevation-1"
          item-value="id"
          dense
        >
          <template #item.actions="{ item }">
            <v-btn icon @click="editUser(item)">
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-btn icon color="red" @click="deleteUser(item)">
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </template>
        </v-data-table>
      </v-card>

      <!-- Dialog for Add/Edit User -->
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>
            <span class="text-h5">{{ dialogMode === 'edit' ? 'Edit' : 'Add' }} User</span>
          </v-card-title>

          <v-card-text>
            <v-form ref="form">
              <v-text-field
                v-model="formData.name"
                label="Name"
                required
              />
              <v-text-field
                v-model="formData.email"
                label="Email"
                required
              />
              <v-text-field
                v-model="formData.password"
                label="Password"
                type="password"
                required
              />
            </v-form>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text @click="closeDialog">Cancel</v-btn>
            <v-btn color="primary" dark @click="saveUser">
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      search: '',
      dialog: false,
      dialogMode: 'add', // 'add' or 'edit'
      headers: [
        { text: 'Name', value: 'name' },
        { text: 'Email', value: 'email' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      users: [], // Dynamically loaded users
      formData: {
        id: null,
        name: '',
        email: '',
        password: '',
      },
    };
  },
  created() {
    this.fetchUsers(); // Fetch users when the component is created
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axios.get('/api/users'); // Fetch users from the API
        this.users = response.data; // Assuming the data is under `data` key
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    },
    openDialog() {
      this.dialogMode = 'add';
      this.resetForm();
      this.dialog = true;
    },
    closeDialog() {
      this.dialog = false;
    },
    resetForm() {
      this.formData = { id: null, name: '', email: '', password: '' };
    },
    async saveUser() {
      try {
        if (this.dialogMode === 'add') {
          // Add new user via API
          const response = await axios.post('/api/user', this.formData)
            .then((response)=>{
                this.users.push(response.data);
                alert("User added Successfully");
            })
            .catch((error)=>{
                const message = Object.keys(error.response.data.errors).map(key => `${key}: ${error.response.data.errors[key]}`).join(', ');
                alert(message);
            });


        } else if (this.dialogMode === 'edit') {
          // Update existing user via API
          await axios.put(`/api/user/${this.formData.id}`, this.formData)
          .then((response)=>{
                this.users.push(this.formData);
                alert("User updated Successfully");
            })
            .catch((error)=>{
                const message = Object.keys(error.response.data.errors).map(key => `${key}: ${error.response.data.errors[key]}`).join(', ');
                alert(message);
            });
          const index = this.users.findIndex((user) => user.id === this.formData.id);
          if (index !== -1) {
            this.users.splice(index, 1, { ...this.formData });
          }
        }
        this.closeDialog();
        this.fetchUsers(); // Refresh user list
      } catch (error) {
        console.error('Error saving user:', error);
      }
    },
    editUser(user) {
      this.dialogMode = 'edit';
      this.formData = { ...user, password: '' }; // Reset password field
      this.dialog = true;
    },
    async deleteUser(user) {
      try {
        await axios.delete(`/api/user/${user.id}`); // Delete user via API
        this.users = this.users.filter((u) => u.id !== user.id);
      } catch (error) {
        console.error('Error deleting user:', error);
      }
    },
  },
};
</script>
