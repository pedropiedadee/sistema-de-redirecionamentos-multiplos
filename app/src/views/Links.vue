<template>
  <div id="all">
    <div id="save-modal" class="opacity modal-aberto">
      <div id="modal">
        <div id="modal-header">
          <p id="modal-title">Criação de Link</p>
          <span @click.stop.prevent="CountInput = 1"
            ><b-icon-x-lg @click="modalSave" class="x-icon m-4 fs-4"
          /></span>
        </div>
        <form @submit.stop.prevent="addLink">
          <div class="container">
            <div id="link-title">
              <label id="title">Titulo Do Link</label>
              <input
                v-model="newRedirect"
                class="input-title-link"
                type="text"
                placeholder="Digite o titulo do seu link"
              />
            </div>
            <div id="infos">
              <p class="title-infos">URL original</p>
              <p class="info-message">
                Você poderá inserir uma ou várias URL's, faça como desejar.
                Lembre-se de inserir a quantidade de cliques junto à URL.
              </p>
            </div>
            <div v-for="key in CountInput" :key="key" class="inputs">
              <div class="id-and-input">
                <label class="id-input">{{ key }}</label>
                <input
                  v-model="links[key]"
                  :id="key"
                  type="text"
                  class="input-link"
                  placeholder="Ex: https://greenn.com.br/"
                />
              </div>
              <input
                v-model="qnt_cliques[key]"
                :id="key"
                type="text"
                class="qnt-cliques"
                placeholder="qnt-cliques"
              />
            </div>
            <div class="modal-buttons">
              <button @click="CountInput++" type="button" class="add-url">
                <span style="margin-right: 10px"><b-icon-plus-lg /></span>
                Adicionar mais URL
              </button>
              <button @click="CountInput--" type="button" class="remove-url">
                <span style="margin-right: 10px"><b-icon-dash-lg /></span>
                Remover URL
              </button>
            </div>
            <div class="mt-3">
              <p class="title-infos mt-4">URL Default</p>
              <p class="info-message">
                Essa URL será associada ao redirecionamento apenas quando todas
                as outras chegarem ao limite de cliques. Ela será a uma url fixa
                sem limitação.
              </p>
            </div>
            <input
              v-model="link_default"
              type="text"
              class="input-title-link"
              placeholder="Insira a URL Default"
            />
            <div class="last">
              <button class="btn-save" type="submit">Salvar Link 💪</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="view-title">
      <div>
        <h1 class="main-text">Links De Redirecionamentos 🌐</h1>
        <h3 id="main-subtext">Crie seus links de redirect em poucos passos</h3>
      </div>
      <button @click="modalSave" id="create-link">Criar um Link</button>
    </div>
    <div class="regua"></div>
    <div id="main">
      <div id="redirects-list">
        <div id="redirect-title">
          <p id="links-number">{{ redirects.length }} Links</p>
          <p id="clicks">Cliques em tempo real</p>
        </div>
        <div v-if="spinner.get_redirects" class="w-3">
          <div class="text-center">
            <div class="spinner-border mt-2 text-primary" role="status">
              <span class="sr-only"></span>
            </div>
          </div>
        </div>
        <div
          v-for="redirect in redirects"
          :key="redirect.id"
          class="card-redirect"
        >
          <div class="card-infos">
            <div class="informations">
              <p class="title-redirect">{{ redirect.nome_link }}</p>
              <p class="date">{{ getDate(redirect.created_at) }}</p>
            </div>
            <p class="link">{{ redirect.link_default }}</p>
          </div>
          <p class="link-click">👉 2/{{ redirect.total_max_click }}</p>
        </div>
      </div>
      <div id="link-infos">
        <div>
          <div class="title-and-date">
            <p class="main-text">{{ redirect.nome_link }}</p>
            <p class="date">
              Criado em: {{ getDate(redirect.created_at) }}
            </p>
          </div>
          <div class="others">
            <a target="_blank" href="youtube.com" class="link">
              {{ redirect.link_default }}</a>
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
                <p class="url">
                  https://www.notion.so/Green-club-8d477635100044e4b3c5ca81c479fbdc
                </p>
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
import moment from "moment";
moment.locale('br')

export default {
  name: "Links",

  data() {
    return {
      newRedirect: "",
      links: [],
      link_default: "",
      qnt_cliques: [],
      spinner: {
        get_redirects: false,
      },
      redirects: [],
      redirect: {},
      CountInput: 1,
    };
  },

  methods: {
    addLink() {
      if (!this.newRedirect) {
        return;
      }

      const payloadRedirect = {
        nome_link: this.newRedirect,
        link_hash: "teste",
        link_default: this.link_default,
        total_max_click: 400,
      };

      this.$axios.post("/redirect", payloadRedirect).then((response) => {
        for (let i = 1; i < this.links.length; i++) {
          const payload = {
            link: this.links[i],
            max_click: this.qnt_cliques[i],
            link_default: this.link_default,
          };

          this.$axios.post(`/redirect/${response.data[0].id}/links`, payload)
        }
        this.redirects.unshift(response.data[0])
        this.links = [];
        this.qnt_cliques = [];
        this.link_default = "";
        this.newRedirect = "";
      });
    },
    getTodos() {
      this.spinner.get_redirects = true;

      this.$axios
        .get("/redirects")
        .then((response) => {
          this.redirects = response.data;
        })
        .finally(() => {
          this.spinner.get_redirects = false;
        });
    },
    getDate: function (date) {
      return moment(date, "YYYY-MM-DD HH:mm").format("DD/MM/YYYY [às] HH:mm");
    },
    getTodo() {
      this.spinner.get_redirects = true;
      this.$axios
        .get(`/redirect/${this.$route.params.id}`)
        .then((response) => {
          this.redirect = response.data.data;
        })
        .finally(() => {
          this.spinner.get_redirects = false;
        });
    },
  },

  setup() {
    const modalSave = () => {
      let modal = document.getElementById("save-modal");
      let hasClass = modal.classList.contains("opacity");

      if (hasClass) {
        modal.classList.remove("opacity");
        modal.classList.remove("translate");
      } else {
        modal.classList.add("opacity");
        modal.classList.add("translate");
      }
    };
    return {
      modalSave,
    };
  },

  created() {
    this.getTodos();
    this.getTodo();
  },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;500&family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:wght@500;600&display=swap");

* {
  font-family: "Montserrat", sans-serif;
}

/* Titulo */
.view-title {
  margin: 50px 20px 25px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.main-text {
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 600;
  font-size: 18px;
  line-height: 22px;
  margin-right: 10px;
  display: flex;
  align-items: center;
  letter-spacing: 0.2px;
  color: #333333;
}

#main-subtext {
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 17px;
  display: flex;
  align-items: center;
  letter-spacing: 0.2px;
  color: #81858e;
}

#create-link {
  color: #2133d2;
  background-color: #2133d21a;
  padding: 10px 50px;
  border-radius: 5px;
  transition: 0.5s;
  border: none;
}

#create-link:hover {
  color: #fff;
  background-color: #2133d2;
}

.regua {
  height: 0px;
  border-bottom: 1px solid #81858e48;
  color: #81858e48;
  margin: 13px 20px;
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
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 600;
  font-size: 16px;
  line-height: 17px;
  letter-spacing: 0.2px;
  color: #2133d2;
}

#clicks {
  font-family: "Montserrat";
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
  cursor: pointer;
}

.card-redirect:hover {
  background-color: #dbdbe41c;
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
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 600;
  font-size: 16px;
  line-height: 17px;
}

.date {
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 400;
  font-size: 12px;
  line-height: 15px;
  color: #81858e;
}

.link {
  display: flex;
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 400;
  font-size: 13px;
  color: #81858e;
}

.link-click {
  display: flex;
  align-items: center;
  justify-content: center;
  color: #81858e;
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
  color: #2133d2;
  background-color: #2133d21a;
  padding: 5px 20px;
  border-radius: 5px;
  transition: 0.5s;
  border: none;
}

.btn-copy:hover {
  color: #fff;
  background-color: #2133d2;
}

.btn-edit {
  margin-left: 10px;
  border: 1px solid #2133d2;
  background-color: transparent;
  padding: 4px 19px;
  border-radius: 5px;
  color: #2133d2;
  transition: 0.5s;
}

.btn-edit:hover {
  float: right;
  color: #fff;
  background-color: #2133d2;
}

.link {
  font-weight: 400;
  font-size: 13px;
  line-height: 16px;
  color: #2133d2;
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
  color: #2133d2;
  margin-right: 10px;
}

.url {
  font-style: normal;
  font-weight: 400;
  font-size: 12px;
  line-height: 15px;
  margin-left: 20px;
  color: #81858e;
}

.id-and-link {
  display: flex;
  align-items: center;
}

.contagem {
  font-weight: 400;
  font-size: 12px;
  line-height: 15px;
  color: #2133d2;
}

.url-e-contagem {
  display: block;
  flex-direction: row;
}

/* Modal de salvar */
#save-modal {
  height: 100%;
  width: 100%;
  background-color: rgba(0, 0, 0, 0.24);
  position: fixed;
  transition: 0.3s;
}

.modal-aberto {
  transform: translate(0, -50px);
}

.opacity {
  transform: translate(1650px, -50px);
  opacity: 0;
}

#modal {
  position: fixed;
  height: 101%;
  width: 49%;
  background-color: #fff;
  overflow-y: scroll;
  overflow-x: none;
  transition: 0.5s;
  transform: translate(700px, -0px);
}

#modal-header {
  display: flex;
  justify-content: space-between;
  background-color: #191b28;
  height: 80px;
  color: white;
}

#modal-title {
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 600;
  font-size: 16px;
  line-height: 20px;
  display: flex;
  align-items: center;
  margin: 15px;
  color: #ffffff;
}

.x-icon {
  cursor: pointer !important;
}

.container {
  margin: 22px;
  display: block;
}

#link-title {
  font-weight: 600;
  font-size: 15px;
  display: block;
  letter-spacing: 0.5px;
  color: #333333;
}

#title {
  font-weight: 600;
  font-size: 16px;
  line-height: 16px;
  display: flex;
  align-items: center;
  letter-spacing: 0.2px;
  color: #333333;
}

.input-title-link {
  display: flex;
  outline: none;
  border: none;
  border-bottom: 1px solid #81858e2d;
  color: #333333b9;
  margin-top: 15px;
  width: 350px;
}

.input-link {
  display: flex;
  outline: none;
  border: none;
  color: #333333b9;
  margin-top: 5px;
  width: 350px;
}

#infos {
  margin-top: 25px;
}

.title-infos {
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 600;
  font-size: 15px;
  line-height: 17px;
  display: flex;
  align-items: center;
  letter-spacing: 0.5px;
  color: #2133d2;
  margin-bottom: 3px;
}

.info-message {
  font-weight: 400;
  font-size: 14px;
  text-align: left;
  align-items: center;
  letter-spacing: 0.2px;
  color: #81858e;
}

.id-and-input {
  display: flex;
}

.inputs {
  display: flex;
  justify-content: space-between;
}

.id-input {
  font-size: 16px;
  margin: 5px 10px;
  font-weight: bold;
  display: flex;
  align-items: center;
  color: #000000;
}

.qnt-cliques {
  border: none;
  outline: none;
  width: 110px;
}

.add-url {
  margin-right: 5px;
  margin-top: 20px;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: 0.5px;
  color: #2133d2;
  padding: 10px 20px;
  border-radius: 5px;
  border: 1px solid #2133d2;
  background-color: transparent;
  transition: 0.3s;
}

.add-url:hover {
  color: white;
  background-color: #2133d2;
}

.remove-url {
  margin-right: 5px;
  margin-top: 20px;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: 0.5px;
  color: #ff0000;
  padding: 10px 40px;
  border-radius: 5px;
  border: 1px solid #ff0000;
  background-color: transparent;
  transition: 0.3s;
}

.remove-url:hover {
  color: white;
  background-color: red;
}

.last {
  margin-top: 110px;
  height: 100%;
  display: flex;
  text-align: center;
  justify-content: center;
}

.btn-save {
  margin-left: 67%;
  border-radius: 5px;
  border: none;
  padding: 10px 40px;
  color: white;
  background-color: #2133d2;
  box-shadow: 0px 4px 10px rgba(33, 51, 210, 0.5);
  transition: 0.5s;
}

.btn-save:hover {
  transform: scale(1.03);
}
</style>


