<template>
<div class="card-redirect">
  <RouterLink class="router" :to="{ path: `/redirect/${redirect.id}`}">
    <div class="card-infos">
      <div class="informations">
        <p class="title-redirect">{{ redirect.nome_link }}</p>
        <p class="date">{{ getDateOnly(redirect.created_at) }}</p>
      </div>
      <p class="link-card">{{ redirect.link_default }}</p>
    </div>
  </RouterLink>
  <p class="link-click d-flex">👉 0/{{ redirect.total_max_click }}</p>
</div>
</template>

<script>
import moment from "moment";
moment.locale("pt-br");

export default {
  name: 'RedirectCard',

  data() {
    return {
    };
  },

  props: {
    redirect: {
      type: Object,
      default: () => ({}),
    },
  },

  methods: {
    getDateOnly: function (date) {
      return moment(date, "YYYY-MM-DD").format(
        "DD/MM/YYYY"
      );      
    },
  },
};
</script>

<style>
.card-redirect {
  border-bottom: 0.5px solid #81858e25;
  background-color: white;
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
  font-family: "Montserrat"!important;
  text-align: left;
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
  color: #81858e;
}

.link {
  display: flex;
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 400;
  padding: 3px;
  border-radius: 3px;
  font-size: 13px;
  color: #81858e!important;
}

.link-card {
  display: flex;
  font-family: "Montserrat";
  font-style: normal;
  font-weight: 400;
  padding: 3px;
  border-radius: 3px;
  outline: none;
  font-size: 13px;
  color: #81858e!important;
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
  white-space: nowrap;
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
</style>
