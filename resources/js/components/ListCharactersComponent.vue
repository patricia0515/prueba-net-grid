<template>
  <div>
    <h1 class="text-center">Lista de Personajes</h1>

    <div class="row row-cols-1 row-cols-md-4">
      <div class="col mb-2" v-for="character of characters" v-bind:key="character.id">
        <div class="card mt-4">
          <img v-bind:src="character.image" class="card-img-top" v-bind:alt="character.name">
          <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-light btn-circle btn-sm" @click="markFavorite(character.id)"></button>
            </div>
            
            <h4 class="card-title">{{ character.name }}</h4>
            
            
            <h6 class="card-text">{{character.location.name}}</h6>
            <div class="d-grid gap-2">
              <button type="button" class="btn btn-primary" @click="getDataCharacter(character.id)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Ver detalles
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <nav aria-label="...">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" v-on:click="changePage(prev,page-1)">Anterior</a>
        </li>
        <li class="page-item">
          <a class="page-link">{{page}}</a>
        </li>
        <li class="page-item">
          <a class="page-link" v-on:click="changePage(next,page+1)">Siguiente</a>
        </li>
      </ul>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header shadow">
            <h5 class="modal-title text-uppercase fs-4" id="exampleModalLabel"><span class="badge rounded-pill text-bg-success">{{ infoCharacter.name }}</span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <blockquote class="blockquote mb-0">
              <p class="fw-bolder">Genero.</p>
              <footer class="blockquote-footer">{{ infoCharacter.gender }}</footer>
            </blockquote>
            <blockquote class="blockquote mb-0">
              <p class="fw-bolder">Estado.</p>
              <footer class="blockquote-footer">{{ infoCharacter.status }}</footer>
            </blockquote>
            <blockquote class="blockquote mb-0">
              <p class="fw-bolder">Especie.</p>
              <footer class="blockquote-footer">{{ infoCharacter.species }}</footer>
            </blockquote>
            <blockquote class="blockquote mb-0">
              <p class="fw-bolder">Tipo.</p>
              <footer class="blockquote-footer">{{ infoCharacter.type }}</footer>
            </blockquote>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>


  </div>
</template>

<script>
export default {
  data() {
    return {
      characters:[],
      page:1,
      pages:1,
      url:"https://rickandmortyapi.com/api/character",
      next:"",
      prev:"",
      modal : false,
      infoCharacter: {}
    }
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
        this.url = url;
        console.log(this.url)
        this.page = (page <= 0 || page > this.pages ) ? this.page : page;
        this.getData();
      },
      getDataCharacter(id){
        this.getDetails(id);
      },
      markFavorite(id){
      },
      async getDetails(id){
        this.infoCharacter = {};
        let result = await axios.get(
          `https://rickandmortyapi.com/api/character/${id}/`
        );
        this.infoCharacter = result.data;
        this.modal = true;
      }
  },
};
</script>