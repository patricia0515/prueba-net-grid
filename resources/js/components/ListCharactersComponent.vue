<template>
  <div>
    <h1 class="text-center">Lista de Personajes</h1>
    <button class="btn btn-success" v-on:click="getData">Consultar</button>

    <div class="row row-cols-1 row-cols-md-4">
      <div class="col mb-2" v-for="character of characters" v-bind:key="character.id">
        <div class="card mt-4">
          <img v-bind:src="character.image" class="card-img-top" v-bind:alt="character.name">
          <div class="card-body">
            <h5 class="card-title">{{ character.name }}</h5>
            <h6 class="card-text">{{character.location.name}}</h6>
            <button class="btn btn-primary rounded" @click="getDataCharacter(character.url)">Ver detalles</button>
          </div>
        </div>
      </div>
    </div>
    <nav aria-label="...">
      <ul class="pagination">
        <li class="page-item" v-on:click="changePage(prev, page-1)">
          <span class="page-link">Anterior</span>
        </li>
        <li class="page-item">
          <a class="page-link">{{page}}</a>
        </li>
        <li class="page-item">
          <a class="page-link" v-on:click="changePage(next,page+1)">Siguiente</a>
        </li>
      </ul>
      
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      characters:[],
      modoEditar: true,
      page:1,
      pages:1,
      url:"https://rickandmortyapi.com/api/character",
      next:"",
      prev:"",
      modal : false,
      currenCharacter: {},
    };
  },
  created(){
    this.getData()
  },
  mounted() {
  },
  
  methods: {
      getData(){
        const params = { page:this.page };
        let resul = axios.get(this.url)
        .then((res) => {
         console.log(res.data.results)
         this.next = res.data.info.next
         this.prev = res.data.info.prev
         this.pages = res.data.info.pages
         this.characters = res.data.results;
        })
        .catch((err) => {
          console.log(err)
        });
      },
      changePage(url, page){
        this.url = url
        this.page = (page <= 0 || page > this.pages ) ? this. page : page;
        this.getData();
      },
      getDataCharacter(id){
        this.getDetails(id);
      },
      async getDetails(url){
        
        let result = await axios.get(url);
        this.currenCharacter = result.data;
        console.log('Personaje: '+this.currenCharacter);
      }
  },
};
</script>