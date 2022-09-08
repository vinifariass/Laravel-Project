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
                  <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID"
                    v-model="busca.id">
                </input-container-component>
              </div>
              <div class="col mb-3">
                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp"
                  texto-ajuda="Opcional. Informe o nome da marca">
                  <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp "
                    v-model="busca.nome" placeholder="Nome da marca">
                </input-container-component>

              </div>

            </div>
          </template>
          <template v-slot:rodape>
            <div class="row">
              <div class="col-10">
                <paginate-component>
                  <li v-for="l, key in marcas.links  " :key="key" :class="l.active ? 'page-item active' : 'page-item'"
                    @click="paginacao(l)">
                    <!-- v-bind na classe -->
                    <a class="page-link" v-html="l.label"></a>
                  </li>
                </paginate-component>
              </div>
              <div class="col">

                <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
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
                :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar' }"
                :atualizar="{visivel:true,dataToggle:'modal',dataTarget:'#modalMarcaAtualizar'}"
                :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaRemover' }"
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
    <!-- inicio modal inclusao de marca -->
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
    <!-- fim modal inclusao de marca -->
    <!-- inicio modal visualizacao de marca -->

    <modal-component id="modalMarcaVisualizar" titulo="Visualizar marca">
      <template v-slot:alertas>
      </template>
      <template v-slot:conteudo>
        {{ $state.state.item }}
        <input-container-component titulo="ID" class="form-control" :value="$store.state.item.id" disabled>
        </input-container-component>

        <input-container-component titulo="Nome da marca" class="form-control" :value="$store.state.item.nome" disabled>
        </input-container-component>

        <input-container-component titulo="Imagem">
          <img :src="'storage/' + $store.state.item.imagem" alt="" v-if="$store.state.item.imagem">
        </input-container-component>

        <input-container-component titulo="Data de criação" class="form-control" :value="$store.state.item.created_at"
          disabled>
        </input-container-component>
      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </template>

    </modal-component>
    <!-- inicio modal remocao de marca -->
    <modal-component id="modalMarcaRemover" titulo="Remover marca">
      <template v-slot:alertas>
        <alert-component tipo="success" titulo="Transação realizada com sucesso"
          :detalhes="{mensagem:$store.state.transacao}" v-if="$store.state.transacao.status == 'sucesso'">
        </alert-component>
        <alert-component tipo="danger" titulo="Erro na transação" :detalhes="{mensagem:$store.state.transacao}"
          v-if="$store.state.transacao.status == 'erro'"></alert-component>
      </template>
      <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
        {{ $state.state.item }}
        <input-container-component titulo="ID" class="form-control" :value="$store.state.item.id" disabled>
        </input-container-component>

        <input-container-component titulo="Nome da máquina" class="form-control" :value="$store.state.item.nome"
          disabled>
        </input-container-component>

      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-damger" @click="remover()"
          v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
      </template>

    </modal-component>
    <!-- inicio modal atualizacao de marcar -->
    <modal-component id="modalMarcaAtualizar" titulo="Atualizar marca">
      <template v-slot:alertas>
      </template>
      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component titulo="Nome da marca" id="atualizarNome" id-help="atualizarNomeHelp"
            texto-ajuda="Opcional. Informe o nome da marca">
            <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
              placeholder="Nome da marca" v-model="nomeMarca">
          </input-container-component>

        </div>

        <div class="form-group">
          <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
            <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp"
              placeholder="Selecione uma imagem" @change="carregarImagem($event)">
          </input-container-component>
        </div>
      </template>

      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
      </template>

    </modal-component>
    <!-- fim modal inclusao de marca -->
    <!-- inicio modal visualizacao de marca -->

    <!-- Fim remoçao marca -->
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
      marcas: { data: [] },
      busca: { id: '', nome: '' },
      urlPaginacao: '',
      urlFiltro: ''
    }
  },
  computed: {

    token() {

      let token = document.cookie.split(';').find(indice => {
        return indice.includes('token=')
      })

      token = token.split('=')[1]
      token = 'Bearer ' + token
      F
      return token
    }
  },
  methods: {
    pesquisar() {
      console.log(this.busca);
      let filtro = ''
      for (let chave in this.busca) {
        filtro += chave + ':like:' + this.busca[chave]
      }
      if (filtro != '')
        this.urlFiltro = '&filtro' + filtro
    },
    remover() {
      let confirmacao = confirm("Tem certeza que deseja remover esse registro?")
      if (!confirmacao)
        return false

      let config = {
        headers: {
          'Accept': 'application.json',
          'Autorizatio-n': this.token
        }
      }



      let url = this.urlBase + '/' + this.$store.state.item.id
      let formData = new FormData();
      formData.append('_method', 'delete');
      axios.post(url, formData, config).then | (response =>
        console.log('Registro removido com sucesso', response))
      this.$store.state.transacao.status = 'sucesso'
      this.$store.state.transacao.status = 'Registro removido com sucesso'
      this.carregarLista()
        .catch(errors => {
          this.$store.state.transacao.status = 'erro'
          this.$store.state.transacao.status = 'Erro ao tentar remover o registro'
        })
    },
    atualizar() { },
    paginacao(l) {
      if (l.url) {
        //this.urlBase = l.url //ajustando a url de consulta com o parametro de pagina
        this.urlPaginacao = l.url.split('?')[1]
        this.carregarLista() //requisitando novamente os dados de pagina

      }
    },
    carregarLista() {
      let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
      axios.get(url)
        .then(response => {
          this.marcas = response.data
          // console.log(this.marcas);
        }).catch(errors => {
          console.log(errors);
        })
      //passa o dados retornados quando é acessada
      let config = {
        headers: {
          'Accept': 'application/json',
          'Authorization': this.token
        }

      }
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