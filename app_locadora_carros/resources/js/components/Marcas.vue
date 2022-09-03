<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <card-component titulo="Busca de marcas">
          <template v-slot:conteudo>
            <div class="form-row">
              <div class="col mb-3">
                <input-container-component titulo="ID" id="inputId" id-help="idHelp"
                  texto-ajuda="Opcional. Informe o ID da marca">
                  <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                </input-container-component>
              </div>
              <div class="col mb-3">
                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp"
                  texto-ajuda="Opcional. Informe o nome da marca">
                  <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp"
                    placeholder="Nome da marca">
                </input-container-component>

              </div>

            </div>
          </template>
          <template v-slot:rodape>
            <div class="row">
              <div class="col-10">
                <paginate-component>

                  <li v-for="l, key in marcas.links  " :key="key" class="page-item"><a class="page-link" href="#"
                      v-html="l.label"></a></li>
                </paginate-component>
              </div>
              <div class="col">

                <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
              </div>

            </div>

          </template>
        </card-component>
        <div class="card mb-3">

          <!-- Fim card de busca -->

          <!-- Inicio card listagem de marcas -->
          <card-component titulo="Relação de marcas">
            <template v-slot:conteudo>
              <table-component :dados="marcas.data"
                :titulos="{ id: { titulo: 'ID', tipo: 'texto' }, nome: { titulo: 'Nome', tipo: 'texto' }, imagem: { titulo: 'Imagem', tipo: 'imagem' }, created_at: { titulo: 'Data de criação', tipo: 'data' } }">
              </table-component>
            </template>
            <template v-slot:rodape>
              <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                data-target="#modalMarca">Adicionar</button>

            </template>
          </card-component>

        </div>
      </div>
    </div>

    <modal-component id="modalMarca" titulo="Adicionar marca">
      <template v-slot:alertas>
        <alert-componet tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso"
          v-if="transacaoStatus == 'adicionado'"></alert-componet>
        <alert-componet tipo="danger" v-if="transacaoStatus == 'erro'" :detalhes="transacaoDetalhes"
          titulo="Erro ao tentar cadastrar a marca"></alert-componet>


      </template>
      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp"
            texto-ajuda="Opcional. Informe o nome da marca">
            <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
              placeholder="Nome da marca" v-model="nomeMarca">
          </input-container-component>
          {{ nomeMarca }}

        </div>

        <div class="form-group">
          <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp"
            texto-ajuda="Selecione uma imagem no formato PNG">
            <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp"
              placeholder="Selecione uma imagem" @change="carregarImagem($event)">
            {{ arquivoImagem }}
          </input-container-component>
        </div>
      </template>

      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
      </template>

    </modal-component>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nomeMarca: '',
      arquivoImagem: [],
      urlBase: 'http://localhost:8000/api/v1/marca',
      transacaoStatus: '',
      transacaoDetalhes: {},
      marcas: { data: [] }
    }
  },
  computed: {
    token() {

      let token = document.cookie.split(';').find(indice => {
        return indice.includes('token=')
      })

      token = token.split('=')[1]
      token = 'Bearer ' + token

      return token
    }
  },
  methods: {
    carregarLista() {

      let config = {
        headers: {
          'Accept': 'application/json',
          'Authorization': this.token
        }

      }
      axios.get(this.urlBase)
        .then(response => {
          this.marcas = response.data
          console.log(this.marcas);
        }).catch(errors => {
          console.log(errors);
        })
      //passa o dados retornados quando é acessada
    },
    carregarImagem(e) {
      this.arquivoImagem = e.target.files
      //forma como recupera os arquivos atribuidos no formulario
    },
    salvar() {
      let formData = new FormData();
      //formulario que define os seus atributos dentro do javascript
      formData.append('nome', this.nomeMarca)
      formData.append('imagem', this.arquivoImagem[0])
      let config = {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Accept': 'application/json',
          'Authorization': this.token
        }
      }
      axios.post(this.urlBase, formData, config)
        .then(response => {
          this.transacaoStatus = 'adicionado'
          this.transacaoDetalhes = { mensagem: 'ID do Registro' + reponse.data.id }
        })
        .catch(errors => {
          this.transacaoStatus = 'erro'
          this.transacaoDetalhes = {
            mensagem: errors.response.data.message,
            dados: errors.response.data.errors
          }
          // console.log(errors.response.data.message);
        })
      //metodo que faz uma requisição para localhost v1 marca,
      //passa o conteudo que sao enviados e as configuracoes no terceiro parametro
    },

  },
  mounted() {
    this.carregarLista()
  }
}
</script>