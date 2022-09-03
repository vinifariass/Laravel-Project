<template>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col" v-for="t, key in titulos" :key="key" class="text-uppercase">{{ t.titulo }}</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td v-for="obj, chave in dadosFiltrados" :key="chave"></td>
        <td v-for="valor, chaveValor in obj" :key="chaveValor">{{ valor }}</td>
      </tr>
      <!-- <tr v-for="obj in dados" :key="obj.id">
        <td v-if="titulos.includes(chave)" v-for="valor, chave in obj " :key="chave">
          {{ chave }} - {{ valor }}
          <span v-if="chave == 'imagem'">
            <img :src="/storage/ + valor" alt="" width="30" height="30">
          </span>
          <span v-else>
            {{ valor }}
          </span>
        </td>
         <th scope="row">{{ m.id }}</th> -->
      <!-- <td>{{ m.nome }}</td>
        <td>{{ m.imagem }}</td>
        <td><img width="30" height="30" :src="/storage/ + m.imagem" alt="">
        </td> 
      </tr> -->

    </tbody>
  </table>
</template>

<script>
export default {
  props: ['dados'],
  computed: {
    dadosFiltrados() {
      let campos = Object.keys(this.titulos)
      let dadosFiltrados = []

      this.dados.map((item, chave) => {
        let itemFiltrado = {}
        // console.log(chave, item)
        campos.forEach(campo => {

          itemFiltrado[campo] = item[campo] //sintaxe de array apara atribuir valores a objetos

        })
        dadosFiltrados.push(itemFiltrado)
      })
      return dadosFiltrados
    }
  }
}
</script>
