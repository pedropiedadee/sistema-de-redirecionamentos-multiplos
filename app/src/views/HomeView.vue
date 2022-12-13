<template>
  <div class="home">
    <div id="barra-lateral">
      <div class="imagens">
        <div>
          <RouterLink to="/redirects">
            <div class="presente">
              <img src="../assets/img/Vectorpresente.png" alt="presente">
            </div>
          </RouterLink>
        </div>
        <div>
          <div class="imagem">
            <img src="../assets/img/Vector.png" alt="chápeu-formatura">
          </div>
          <div class="imagem">
            <img src="../assets/img/Vectortrofeu.png" alt="troféu">
          </div>
          <div class="imagem">
            <img src="../assets/img/Vectorpessoa.png" alt="troféu">
          </div>
          <div class="imagem">
            <img src="../assets/img/Vectorcomentario.png" alt="troféu">
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div id="title-home">
        <h1>Pedro Piedade</h1>
        <h2>Teste G</h2>
      </div>
    </div>

  </div>
</template>

<style>
#barra-lateral {
  position: fixed;
  transform: translateY(-325px);
  height: 115vh;
  width: 15vh;
  border-right: 1px solid #33333327;
  display: block;
}

.imagens {
  display: block;
  margin-top: 25vh;
  align-items: center;
  justify-content: center;
}

.imagem {
  margin-bottom: 10vh;
}

.presente {
  transition: .5s;
  margin-bottom: 15vh;
}

.presente:hover {
  transform: scale(1.05);
}


.container {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

#title-home {
  margin-top: 25%;
}
</style>

<script>
// @ is an alias to /src

export default {
  name: 'HomeView',
  components: {}
}
</script>
