<template>
  <div id="all">
    <div id="save-modal" class="opacity modal-aberto">
      <div id="modal">
        <div id="modal-header">
          <p id="modal-title">Criação de Link</p>
          <span @click.stop.prevent="CountInput = 1"><b-icon-x-lg @click="modalSave" class="x-icon m-4 fs-4" /></span>
        </div>
        <ValidationObserver ref="linkForm" tag="form" @submit.stop.prevent="addLink">
          <div class="container">
            <div id="link-title">
              <label id="title">Titulo Do Link</label>
              <ValidationProvider v-slot="{ errors }" rules="required" name="title">
                <input v-model="newRedirect" class="input-title-link" type="text"
                  placeholder="Digite o titulo do seu link" />

                <div v-if="!!errors[0]" class="d-flex mt-1 text-danger">
                  Preencha o campo titulo.
                </div>
              </ValidationProvider>
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
                <ValidationProvider v-slot="{ errors }" rules="required|url" name="link">
                  <input v-model="links[key]" :id="key" type="text" class="input-link"
                    placeholder="Ex: https://greenn.com.br/" />
                  <div v-if="!!errors[0]" class="d-flex mt-1 text-danger">
                    Adicione um link.
                  </div>
                </ValidationProvider>
              </div>
              <ValidationProvider v-slot="{ errors }" rules="numeric|required" name="qnt_cliques">
                <input v-model="qnt_cliques[key-1]" :id="key" type="text" class="qnt-cliques" placeholder="qnt-cliques" />
                <div v-if="!!errors[0]" class="d-flex mt-1 text-danger">
                  Adicione a quantidade de cliques.
                </div>
              </ValidationProvider>
            </div>
            <div class="modal-buttons">
              <button @click="CountInput++" type="button" class="add-url">
                <span style="margin-right: 10px"><b-icon-plus-lg /></span>
                Adicionar mais URL
              </button>
              <button v-if="CountInput == 1" type="button" class="remove-url">
                <span style="margin-right: 10px"><b-icon-dash-lg /></span>
                Remover URL
              </button>
              <button v-else @click="CountInput--" type="button" class="remove-url">
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
            <ValidationProvider v-slot="{ errors }" rules="required|url" name="url_default">
              <input v-model="link_default" type="text" class="input-title-link" placeholder="Insira a URL Default" />
              <div v-if="!!errors[0]" class="d-flex mt-1 text-danger">
                Adicione um link default.
              </div>
            </ValidationProvider>
            <div class="last">
              <button class="btn-save" type="submit">Salvar Link 💪</button>
            </div>
          </div>
        </ValidationObserver>
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
        <RedirectCard
          v-for="redirect in redirects" 
          :key="redirect.id"
          :redirect="redirect"
        />
      </div>
      <div id="link-infos">
        <div>
          <div class="title-and-date">
            <p class="main-text mr-3">{{ redirect.nome_link }}</p>
            <p class="date mb-2">Criado em: {{ getDate(redirect.created_at) }}</p>
          </div>
          <div class="others">
            <input 
              type="text"
              class="link"
              ref="copiar" 
              v-model="redirect.link_default"
              v-on:focus="$event.target.select()"
            />
            <div class="buttons">
              <button @click="copy" class="btn-copy">Copiar</button>
              <button @click="modalShow = true" v-b-modal="`modalEdit-`+ redirect.id" class="btn-edit">Editar</button>
            </div>
          </div>
        </div>
        <b-modal v-if="modalShow" hide-footer :id="`modalEdit-`+ redirect.id" title="Edite seu redirecionador">
          <ValidationObserver 
            ref="editForm" 
            tag="form" 
            @submit.stop.prevent="updateRedirect(redirect)"
          >
            <div class="w-100">
              <label for="redirect">Nome</label>
              <ValidationProvider v-slot="{ errors }" rules="required" name="redirectEdit">
               <input class="form-control" name="redirect" type="text" v-model="redirect.nome_link">
               <div v-if="!!errors[0]" class="d-flex mt-1 text-danger">
                  Adicione um nome para o redirect.
               </div>
             </ValidationProvider>
            </div>
            <div class="mt-4 w-100">
              <label for="cliques">Link default</label>
              <ValidationProvider v-slot="{ errors }" rules="url|required" name="qnt_cliques">
                <input class="form-control" name="cliques" type="text" v-model="redirect.link_default">
                <div v-if="!!errors[0]" class="d-flex mt-1 text-danger">
                    Adicione um link default.
                </div>
              </ValidationProvider>
            </div>
            <button type="submit" class="btn btn-primary mt-3" v-b-modal="`modal-`+ redirect.id">
              Salvar edição
            </button> 
          </ValidationObserver> 
        </b-modal>
        <LinkCard 
          v-for="link in redirect.links" 
          :key="link.id"
          :link="link"
        />
      </div>
    </div>
  </div>
</template>

<script>
import RedirectCard from '../components/RedirectCard.vue'
import LinkCard from '../components/LinkCard.vue'
import { ValidationObserver, ValidationProvider } from "vee-validate";
import moment from "moment";
moment.locale("pt-br");

export default {
  name: "Links",

  components: {
    ValidationObserver,
    ValidationProvider,
    LinkCard,
    RedirectCard,
  },

  data() {
    return {
      textCopy: "",
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
      modalShow: false,
      soma: 0,
    };
  },

  methods: {
    copy() {
      this.$refs.copiar.focus();
      document.execCommand("copy");

      this.$toast.info("Link copiado para área de transferência!", {
        position: "bottom-center",
        timeout: 5000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: "button",
        icon: true,
        rtl: false
      });
    },

    async addLink() {
      const validator = await this.$refs.linkForm.validate();

      if (!validator) {return;}

      var arrayNumber = this.qnt_cliques.map(Number);

      for(var i = 0; i < arrayNumber.length; i++) {
        this.soma += arrayNumber[i];
      }
    
      const payloadRedirect = {
        nome_link: this.newRedirect,
        link_hash: "#"+this.newRedirect.split(' ').join('').toLowerCase(),
        link_default: this.link_default,
        total_max_click: this.soma,
      };

      this.$axios.post("/redirect", payloadRedirect).then((response) => {
        for (let i = 1; i < this.links.length; i++) {
          const payload = {
            link: this.links[i],
            max_click: this.qnt_cliques[i-1],
            link_default: this.link_default,
          };
          this.$axios.post(`/redirect/${response.data[0].id}/links`, payload);
        }
        this.redirects.unshift(response.data[0]);
        this.links = [];
        this.qnt_cliques = [];
        this.link_default = "";
        this.newRedirect = "";
        this.$toast.success("Link criado com sucesso!", {
          position: "top-left",
          timeout: 4984,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 0.6,
          showCloseButtonOnHover: false,
          hideProgressBar: true,
          closeButton: "button",
          icon: true,
          rtl: false
        });
      });
    },
    getRedirects() {
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
      return moment(date, "YYYY-MM-DD HH:mm:ss ").format(
        "DD/MM/YYYY [às] HH:mm"
      );
    },
    getLink() {
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

    updateRedirect(redirect) {
      const payload = {
        nome_link: redirect.nome_link,
        link_hash: "#"+redirect.nome_link.split(' ').join('').toLowerCase(),
        total_max_click: 450,
        link_default: redirect.link_default
      }
      this.$axios.put(`redirect/${redirect.id}`, payload).then(() => {
        this.modalShow = false;
      })
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
    this.getRedirects();
    this.getLink();
  },
};
</script>

<style>

@import url("https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;500&family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:wght@500;600&display=swap");

* {
  font-family: "Montserrat", sans-serif!important;
}



.router {
  text-decoration: none;
  color: inherit;
  width: 80%;
}

.router:hover {
  text-decoration: none;
  color: inherit;
}

/* Titulo */
.view-title {
  margin: 50px 20px 25px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.main-text {
  margin-bottom: 5px;
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 600;
  font-size: 18px;
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

.link {
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


/* Card Links */

</style>


