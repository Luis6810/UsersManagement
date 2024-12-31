<template>
    <v-container class="mt-5" style="max-width: 400px;">
      <v-card>
        <v-card-title class="text-h5">Register</v-card-title>

        <v-card-text>
          <v-form ref="form" v-model="valid">
            <!-- Name Field -->
            <v-text-field
              v-model="formData.name"
              label="Name"
              :rules="[rules.required]"
              outlined
              required
            ></v-text-field>

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
          <v-btn color="primary" @click="submit" :disabled="!valid">Register</v-btn>
        </v-card-actions>
      </v-card>
    </v-container>
  </template>


<script>
import router from '../router';
import axios from 'axios';

export default {
  data() {
    return {
      valid: false, // Form validity
      formData: {
        name: '',
        email: '',
        password: '',
      },
      rules: {
        required: (value) => !!value || 'This field is required',
        email: (value) =>
          /.+@.+\..+/.test(value) || 'E-mail must be valid',
        password: (value) =>
          (value && value.length >= 6) || 'Password must be at least 6 characters',
      },
    };
  },
  methods: {
    submit() {
        axios.post('/api/register', this.formData)
            .then(function (response) {
                console.log(response);
                let token = response.data.authorization.token
                document.cookie = "JWTtoken=" + token;
                alert("User Register Success");
                router.push({name:"Login"});
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
    },
  },
};
</script>
