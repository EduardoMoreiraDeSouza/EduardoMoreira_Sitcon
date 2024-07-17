let profissionalSelecionado = document.getElementById('profissional');
let vazioTipoSolicitacao = document.getElementById('vazio_tipoSolicitacao');
let vazioProcedimentos = document.getElementById('vazio_procedimentos');

if (profissionalSelecionado) {
    profissionalSelecionado.onclick = function () {
        let habilita = profissional()
        tipoSolicitacao(habilita)
        vazioTipoSolicitacao.selected = true;
        vazioProcedimentos.selected = true;
    }
}

let tipoSolicitacaoSelecionada = document.getElementById('tipoSolicitacao');

if (tipoSolicitacaoSelecionada) {
    tipoSolicitacaoSelecionada.onclick = function () {
        let habilita = profissional()
        tipoSolicitacao(habilita)
        vazioProcedimentos.selected = true;
    }
}

function tipoSolicitacao(habilita) {
    let tipoSolicitacaoSelecionada = document.getElementById('tipoSolicitacao');

    if (tipoSolicitacaoSelecionada.value !== '') {
        for (let i = 0; i < tipoSolicitacaoProcedimento.length; i++) {
            if (tipoSolicitacaoProcedimento[i].split(' procedimento ')[1] === tipoSolicitacaoSelecionada.value) {
                if (habilita.includes(tipoSolicitacaoProcedimento[i].split(' procedimento ')[0]) === true) {
                    document.getElementById(tipoSolicitacaoProcedimento[i].split(' procedimento ')[0]).disabled = false;
                    document.getElementById(tipoSolicitacaoProcedimento[i].split(' procedimento ')[0]).style.color = 'black';
                    document.getElementById(tipoSolicitacaoProcedimento[i].split(' procedimento ')[0]).style.fontWeight = '600';
                }
            }
            else {
                document.getElementById(tipoSolicitacaoProcedimento[i].split(' procedimento ')[0]).disabled = true;
                document.getElementById(tipoSolicitacaoProcedimento[i].split(' procedimento ')[0]).style.color = 'rgba(112,111,111,0.76)';
                document.getElementById(tipoSolicitacaoProcedimento[i].split(' procedimento ')[0]).style.fontWeight = 'normal';
            }
        }
    }


}

function profissional() {

    let profissionalSelecionado = document.getElementById('profissional');
    let habilita = [];

    if (profissionalSelecionado.value !== '') {
        for (let i = 0; i < profissionalAtende.length; i++) {
            if (profissionalAtende[i].split(' atende ')[0] === profissionalSelecionado.value) {
                habilita.push(profissionalAtende[i].split(' atende ')[1]);
                document.getElementById(profissionalAtende[i].split(' atende ')[1]).disabled = false;
                document.getElementById(profissionalAtende[i].split(' atende ')[1]).style.color = 'black';
                document.getElementById(profissionalAtende[i].split(' atende ')[1]).style.fontWeight = '600';
            }
            else {
                if (habilita.includes(profissionalAtende[i].split(' atende ')[1]) === false) {
                    document.getElementById(profissionalAtende[i].split(' atende ')[1]).disabled = true;
                    document.getElementById(profissionalAtende[i].split(' atende ')[1]).style.color = 'rgba(112,111,111,0.76)';
                    document.getElementById(profissionalAtende[i].split(' atende ')[1]).style.fontWeight = 'normal';
                }
            }
        }
    }

    return habilita;
}