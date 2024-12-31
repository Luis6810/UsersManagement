<!-- <template>
    <div>
      <h1>Login</h1>
      <form @submit.prevent="handleLogin">
        <input type="email" v-model="email" placeholder="Email" required />
        <input type="password" v-model="password" placeholder="Password" required />
        <button type="submit">Login</button>
        <v-btn color="primary"type="submit">Login</v-btn>
      </form>
    </div>
  </template> -->

<template>
    <v-container class="mt-5" style="max-width: 400px;">
      <v-card>
        <v-card-title class="text-h5">Login</v-card-title>

        <v-card-text>
          <v-form ref="form" v-model="valid">
            <!-- Email Field -->
            <v-text-field
              v-model="formData.email"
              label="Email"
              :rules="[rules.required, rules.email]"
              outlined
              required
            ></v-text-field>

            <!-- Password Field -->
            <v-text-field
              v-model="formData.password"
              label="Password"
              type="password"
              :rules="[rules.required, rules.password]"
              outlined
              required
            ></v-text-field>
          </v-form>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="handleLogin">Login</v-btn>
          <!-- <v-btn color="primary" @click="handleLogin">Login</v-btn> -->
        </v-card-actions>
      </v-card>
    </v-container>
  </template>


  <script>
import axios from 'axios';
import router from '../router';

  export default {
    data() {
    return {
      valid: false, // Form validity
      formData: {
        email: '',
        password: '',
      },
      rules: {
        email: (value) =>
          /.+@.+\..+/.test(value) || 'E-mail must be valid',
        password: (value) =>
          (value && value.length >= 6) || 'Password must be at least 6 characters',
      },
    };
  },
    methods: {
      async handleLogin() {
        axios.post('/api/login', this.formData)
            .then(function (response) {
                console.log(response);
                let token = response.data.authorization.token
                document.cookie = "JWTtoken=" + token;

                router.push({name:"dashboard"});
                // this.$route.router.go('dashboard');

                // window.location.href = "dashboard"
                // axios.get("/api/dashboard");
                // const config = axios.create({
                //     // baseURL: '/dashboard',
                //     headers: {'Authorization': token}
                // });


                // axios.get("/dashboard",{
                //     headers: {
                //         Authorization: `Bearer ${token}`
                //     }
                // }).then(function(response) { console.log(response) });

            })
            .catch(function (error) {
                console.log(error);

                if(error.response.status == 401){
                    alert(error.response.data.message)
                }
                else if (error.response.status == 422){
                    const message = Object.keys(error.response.data.errors).map(key => `${key}: ${error.response.data.errors[key]}`).join(', ');
                    alert(message);
                }


            });
        // try {
        //   const response = await axios.post('/api/login', {
        //     email: this.email,
        //     password: this.password,
        //   });
        //   alert(response.data.message);
        // } catch (error) {
        //   console.error(error);
        //   alert('Login failed');
        // }
      },
    },
  };
  </script>
