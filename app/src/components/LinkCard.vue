<template>
  <div>
    <div class="card-link">
      <div class="card-link-infos">
        <div class="id-and-link">
          <p class="id-link">{{ link.id }}</p>
          <div class="url-e-contagem">
            <p class="url">{{ link.link }}</p>
            <p class="contagem">0/{{ link.max_click }}</p>
          </div>
        </div>
        <button @click="modalShow = true" class="btn-edit" v-b-modal="`modal-`+ link.id">
          Editar
        </button>    
        <b-modal v-if="modalShow" hide-footer :id="`modal-`+ link.id" title="Edite Seu Link">
          <ValidationObserver 
            ref="editForm" 
            tag="form" 
            @submit.stop.prevent="updateLink(link)"
          >
            <div class="" style="width: 100%;">
              <label for="link">Link</label>
              <ValidationProvider v-slot="{ errors }" rules="required|url" name="linkEdit">
               <input class="form-control" name="link" type="text" v-model="link.link">
               <div v-if="!!errors[0]" class="d-flex mt-1 text-danger">
                  Adicione um link válido.
               </div>
             </ValidationProvider>
            </div>
            <div class="mt-4" style="width: 100%;">
              <label for="cliques">Máximo de cliques</label>
              <ValidationProvider v-slot="{ errors }" rules="numeric|required" name="qnt_cliques">
                <input class="form-control" name="cliques" type="text" v-model="link.max_click">
                <div v-if="!!errors[0]" class="d-flex mt-1 text-danger">
                    Adicione a quantidade de cliques.
                </div>
              </ValidationProvider>
            </div>
            <button type="submit" class="btn btn-primary mt-3" v-b-modal="`modal-`+ link.id">
              Salvar edição
            </button> 
          </ValidationObserver> 
        </b-modal>        
      </div>
    </div>
  </div>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate";

export default {
  name: "LinkCard",

  props: {
    link: {
      type: Object,
      default: () => ({}),
    },
  },

  components: {
    ValidationObserver,
    ValidationProvider,
  },

  data() {
    return {
      modalShow: false,
      totalMaxClick: 0,
      redirect: {},
      somaEdit: 0,
    };
  },

  methods: {
    async updateLink(link) {
      const validator = await this.$refs.editForm.validate();

      if (!validator) { return; }

      const payload = {
        link: link.link,
        max_click: link.max_click,
      };

      this.$axios.put(`links/${link.id}`, payload).then(() => {
      this.$axios
        .get(`/redirect/${this.$route.params.id}`)
        .then((response) => {
          this.redirect = response.data.data;

          console.log(this.redirect)

          for(var i = 0; i < this.redirect.links.length; i++) {
            this.somaEdit += this.redirect.links[i].max_click;
          }

          console.log(this.somaEdit);

          const payload = {
            nome_link: this.redirect.nome_link,
            link_hash: "#"+this.redirect.nome_link.split(' ').join('').toLowerCase(),
            total_max_click: this.somaEdit,
            link_default: this.redirect.link_default
          }

          this.$axios.put(`redirect/${this.redirect.id}`, payload)
        })
        
      });
      this.modalShow = false;
        this.$toast.success("Edição realizada com sucesso!", {
          position: "top-left",
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
  },
};
</script>

<style>
.card-link {
  border-radius: 15px;

  padding: 20px;
  transition: 0.2s;
}

.card-link:hover {
  box-shadow: 7px 7px 27px 0px rgba(0, 0, 0, 0.13);
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

.close {
  background-color: transparent;
  color: rgb(0, 0, 0);
  border: none;
  font-size: 50px;
}

.url {
  text-align: left;
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 15px;
  margin-left: 6px;
  margin-bottom: 5px;
  color: #81858e;
}

.id-and-link {
  display: flex;
  align-items: center;
}

.contagem {
  text-align: left;
  border-radius: 2px;
  margin-left: 5px;
  font-size: 12px;
  color: #2133d2;
}

.url-e-contagem {
  display: block;
  width: 80%;
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