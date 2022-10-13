<template>
  <div>
    <form @submit.prevent="editarUser(user)" v-if="modoEditar">
      <h3>Complete la información</h3>
      
      <input
        type="text"
        class="form-control mb-2"
        placeholder="Dirección de residencia"
        v-model="user.address"
      />
      <input
        type="text"
        class="form-control mb-2"
        placeholder="Ciudad de residencia"
        v-model="user.city"
      />
      <input
        type="date"
        class="form-control mb-2"
        placeholder="Fecha de nacimiento"
        v-model="user.birthdate"
      />
      <button class="btn btn-warning" type="submit">Guardar</button>
      <button class="btn btn-danger" type="submit" @click="cancelarEdicion">
        Cancelar
      </button>
      <hr />
    </form>
    

    <h3>Lista de usuarios:</h3>
    <ul class="list-group">
      <li class="list-group-item" 
        v-for="(item, index) in users" :key="index">
        <p>{{ item.name }}</p>
        <p>{{ item.email }}</p>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  data() {
    return {
      users: [],
      modoEditar: true,
      user: { city: "", address: "", birthdate:""},
    };
  },
  mounted() {
    
  },
  created() {
    axios.get("/users").then((res) => {
      this.users = res.data;
    });
  },
  methods: {
    agregar() {
      if (this.user.birthdate.trim() === "" || this.user.city.trim() === "" || this.user.address.trim() === "") {
        alert("Debes completar todos los campos antes de guardar");
        return;
      }
      const userNew = this.user;
      this.user = { city: "", address: "", birthdate:"" };
      axios.post("/users", userNew).then((res) => {
        const userServidor = res.data;
        this.users.push(userServidor);
      });
    },
    editarUser(user) {
      const params = { id:user.id, birthdate: user.birthdate, address: user.address, city: user.city };
      axios.put(`/users/${user.id}`, params).then((res) => {
        this.modoEditar = false;
        const index = this.users.findIndex((item) => item.id === user.id);
        this.users[index] = res.data;
      });
    },
    
    cancelarEdicion() {
      this.modoEditar = false;
      this.user = { city: "", address: "", birthdate:"" };
    },
  },
};
</script>