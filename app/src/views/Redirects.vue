<template>
  <div id="all">
    <div class="view-title">
      <div>
        <h1 class="main-text">Links De Redirecionamentos 🌐</h1>
        <h3 id="main-subtext">Crie seus links de redirect em poucos passos</h3>
      </div>
      <button id="create-link">Criar um Link</button>
    </div>
    <div class="regua">
      <hr>
    </div>
    <div id="main">
      <div id="redirects-list">
        <div id="redirect-title">
          <p id="links-number">04 Links</p>
          <p id="clicks">Cliques em tempo real</p>
        </div>
        <div v-if="spinner.get_redirects" class="w-3">
          <div class="text-center">
            <div class="spinner-border mt-2 text-primary" role="status">
              <span class="sr-only"></span>
            </div>
          </div>
        </div>
        <div v-for="redirect in redirects" :key="redirect.id" class="card-redirect">
          <div class="card-infos">
            <div class="informations">
              <p class="title-redirect"> {{ redirect.nome_link }}</p>
              <p class="date">{{ redirect.created_at }}</p>
            </div>
            <p class="link">{{ redirect.link_hash }}</p>
          </div>
          <p class="link-click">👉 2/{{ redirect.total_max_click }}</p>
        </div>
      </div>
      <div id="link-infos">
        <div>
          <div class="title-and-date">
            <p class="main-text">Link Legal</p>
            <p class="date">Criado em: 09/12/2022 as 14:56</p>
          </div>
          <div class="others">
            <a target="_blank" href="youtube.com" class="link">youtube.com</a>
            <div class="buttons">
              <button class="btn-copy">Copiar</button>
              <button class="btn-edit">Editar</button>
            </div>
          </div>
        </div>
        <div class="card-link">
          <div class="card-link-infos">
            <div class="id-and-link">
              <p class="id-link">01</p>
              <div class="url-e-contagem">
                <p class="url">https://www.notion.so/Green-club-8d477635100044e4b3c5ca81c479fbdc</p>
                <p class="contagem">02/250</p>
              </div>
            </div>
            <button class="btn-edit">Editar</button>
          </div>
        </div>
        <div class="card-link">
          <div class="card-link-infos">
            <div class="id-and-link">
              <p class="id-link">01</p>
              <div class="url-e-contagem">
                <p class="url">https://www.notion.so/Green-club-8d477635100044e4b3c5ca81c479fbdc</p>
                <p class="contagem">02/250</p>
              </div>
            </div>
            <button class="btn-edit">Editar</button>
          </div>
        </div>
        <div class="card-link">
          <div class="card-link-infos">
            <div class="id-and-link">
              <p class="id-link">01</p>
              <div class="url-e-contagem">
                <p class="url">https://www.notion.so/Green-club-8d477635100044e4b3c5ca81c479fbdc</p>
                <p class="contagem">02/250</p>
              </div>
            </div>
            <button class="btn-edit">Editar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Redirects',

  data() {
    return {
      spinner: {
        get_redirects: false
      },
      redirects: [],
    };
  },

  created() {
    this.getTodos();
  },

  methods: {
    getTodos() {
      this.spinner.get_redirects = true;
      this.$axios.get('/redirect').then((response) => {
        console.log(response.data)
        this.redirects = response.data;
      }).finally(() => {
        this.spinner.get_redirects = false;
      });
    },
  },

};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;500&family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:wght@500;600&display=swap');

* {
  font-family: 'Montserrat', sans-serif;
}

/* Titulo */
.view-title {
  margin: 50px 20px 25px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.main-text {
  font-family: 'Montserrat';
  font-style: normal;
  font-weight: 600;
  font-size: 18px;
  line-height: 22px;
  margin-right: 10px;
  /* identical to box height */
  display: flex;
  align-items: center;
  letter-spacing: 0.2px;
  color: #333333;
}

#main-subtext {
  font-family: 'Montserrat';
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 17px;
  /* identical to box height */
  display: flex;
  align-items: center;
  letter-spacing: 0.2px;
  color: #81858E;
}

#create-link {
  color: #2133D2;
  background-color: #2133D21A;
  padding: 10px 50px;
  border-radius: 5px;
  transition: .5s;
  border: none;
}

#create-link:hover {
  color: #FFF;
  background-color: #2133D2;
}


.regua {
  color: #81858e48;
  margin: 0 20px;
}

/* Listagem de redirects */
#main {
  display: flex;
  width: 100%;
  height: 100%;
}

#redirects-list {
  height: 100%;
  width: 40%;
}

#redirect-title {
  border-bottom: 0.5px solid #81858e25;
  padding: 10px 20px 10px 0px;
  margin: 0 0 0 20px;
  display: flex;
  height: 100%;
  justify-content: space-between;
}

#links-number {
  font-family: 'Montserrat';
  font-style: normal;
  font-weight: 600;
  font-size: 16px;
  line-height: 17px;
  letter-spacing: 0.2px;
  color: #2133D2;
}

#clicks {
  font-family: 'Montserrat';
  font-style: normal;
  font-weight: 400;
  font-size: 12px;
  line-height: 15px;
  align-items: center;
  letter-spacing: 0.2px;
  color: #616166;
}

/* card-redirects */
.card-redirect {
  border-bottom: 0.5px solid #81858e25;
  padding: 25px 20px 10px 0px;
  margin: 0 0 0 20px;
  display: flex;
  height: 100%;
  justify-content: space-between;
}

.card-infos {
  width: 50%;
  display: block;
  align-items: center;
  justify-content: center;
}

.informations {
  display: flex;
}


.title-redirect {
  margin-right: 15px;
  font-family: 'Montserrat';
  font-style: normal;
  font-weight: 600;
  font-size: 16px;
  line-height: 17px;
}

.date {
  font-family: 'Montserrat';
  font-style: normal;
  font-weight: 400;
  font-size: 12px;
  line-height: 15px;
  color: #81858E;
}

.link {
  display: flex;
  font-family: 'Montserrat';
  font-style: normal;
  font-weight: 400;
  font-size: 13px;
  color: #81858E;
}

.link-click {
  display: flex;
  align-items: center;
  justify-content: center;
  color: #81858E;
}

/* Informações do link */
#link-infos {
  float: right;
  margin: 40px 40px;
  width: 60%;
  height: 100%;
}

.title-and-date {
  display: flex;
  align-items: center;
  width: 100%;
}

.others {
  display: flex;
  align-items: center;
  width: 100%;
  margin-bottom: 5px;
}

.buttons {
  margin-left: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-copy {
  color: #2133D2;
  background-color: #2133D21A;
  padding: 5px 20px;
  border-radius: 5px;
  transition: .5s;
  border: none;
}

.btn-copy:hover {
  color: #FFF;
  background-color: #2133D2;
}

.btn-edit {
  margin-left: 10px;
  border: 1px solid #2133D2;
  background-color: transparent;
  padding: 4px 19px;
  border-radius: 5px;
  color: #2133D2;
  transition: .5s;
}

.btn-edit:hover {
  float: right;
  color: #FFF;
  background-color: #2133D2;
}

.link {
  font-weight: 400;
  font-size: 13px;
  line-height: 16px;
  color: #2133D2;
  text-decoration: none;
}

/* Card Links */
.card-link {
  margin-top: 40px;
}

.card-link-infos {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.id-link {
  color: #2133D2;
  margin-right: 10px;
}

.url {
  font-style: normal;
  font-weight: 400;
  font-size: 12px;
  line-height: 15px;
  margin-left: 20px;
  color: #81858E;
}

.id-and-link {
  display: flex;
  align-items: center;
}

.contagem {
  font-weight: 400;
  font-size: 12px;
  line-height: 15px;
  color: #2133D2;
}

.url-e-contagem{
  display: block;
  flex-direction: row;
}
</style>


