<!-- Importação de Modais -->
<?php echo view('components/acoes/modal-editar-acao.php'); ?>
<?php echo view('components/acoes/modal-confirmar-exclusao.php'); ?>
<?php echo view('components/acoes/modal-adicionar-acao.php'); ?>
<?php echo view('components/acoes/modal-solicitar-edicao.php'); ?>
<?php echo view('components/acoes/modal-solicitar-exclusao.php'); ?>
<?php echo view('components/acoes/modal-solicitar-inclusao.php'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ações do Plano: <?= $plano['nome'] ?></h1>
        <a href="<?= site_url('planos') ?>" class="btn btn-secondary btn-icon-split btn-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Voltar para Planos</span>
        </a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4 mx-md-5 mx-3">
        <div class="card-body">
            <form id="formFiltros">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="filterAcao">Ação</label>
                            <select class="form-control" id="filterAcao" name="acao">
                                <option value="">Todas as ações</option>
                                <?php foreach ($acoes as $acao): ?>
                                    <option value="<?= $acao['acao'] ?>"><?= $acao['acao'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="filterProjetoVinculado">Projeto Vinculado</label>
                            <select class="form-control" id="filterProjetoVinculado" name="projeto_vinculado">
                                <option value="">Todos os projetos</option>
                                <?php foreach ($acoes as $acao): ?>
                                    <?php if (!empty($acao['projeto_vinculado'])): ?>
                                        <option value="<?= $acao['projeto_vinculado'] ?>"><?= $acao['projeto_vinculado'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="filterEixo">Eixo</label>
                            <select class="form-control" id="filterEixo" name="id_eixo">
                                <option value="">Todos os eixos</option>
                                <?php foreach ($eixos as $eixo): ?>
                                    <option value="<?= $eixo['id'] ?>"><?= $eixo['nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 text-right">
                        <button type="button" id="btnLimparFiltros" class="btn btn-secondary btn-icon-split btn-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-broom"></i>
                            </span>
                            <span class="text">Limpar</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-icon-split btn-sm mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-filter"></i>
                            </span>
                            <span class="text">Filtrar</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 mx-md-5 mx-3">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Ações</h6>
            <?php if (auth()->user()->inGroup('admin')): ?>
                <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#addAcaoModal">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Incluir Ação</span>
                </a>
            <?php else: ?>
                <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#solicitarInclusaoModal">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Solicitar Inclusão</span>
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="dataTable" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Ação</th>
                            <th>Descrição</th>
                            <th>Projeto Vinculado</th>
                            <th>Responsáveis</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($acoes) && !empty($acoes)) : ?>
                            <?php foreach ($acoes as $acao) :
                                $id = $acao['id'] . '-' . str_replace(' ', '-', strtolower($acao['acao'])); ?>
                                <tr>
                                    <td class="text-wrap align-middle"><?= $acao['acao'] ?></td>
                                    <td class="text-wrap align-middle"><?= $acao['descricao'] ?></td>
                                    <td class="text-wrap align-middle"><?= $acao['projeto_vinculado'] ?></td>
                                    <td class="text-wrap align-middle"><?= $acao['responsaveis'] ?></td>
                                    <td class="text-center align-middle">
                                        <div class="d-inline-flex">
                                            <!-- Botão Visualizar Metas -->
                                            <a href="<?= site_url('metas/' . $acao['id']) ?>" class="btn btn-info btn-sm mx-1" style="width: 32px; height: 32px;" title="Visualizar Metas">
                                                <i class="fas fa-bullseye"></i>
                                            </a>

                                            <!-- Botão Visualizar Etapas -->
                                            <a href="<?= site_url('etapas/' . $acao['id']) ?>" class="btn btn-secondary btn-sm mx-1" style="width: 32px; height: 32px;" title="Visualizar Etapas">
                                                <i class="fas fa-tasks"></i>
                                            </a>

                                            <?php if (auth()->user()->inGroup('admin')): ?>
                                                <!-- Botão Editar -->
                                                <button type="button" class="btn btn-primary btn-sm mx-1" style="width: 32px; height: 32px;" data-id="<?= $id ?>" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Botão Excluir -->
                                                <button type="button" class="btn btn-danger btn-sm mx-1" style="width: 32px; height: 32px;" data-id="<?= $id ?>" title="Excluir">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            <?php else: ?>
                                                <!-- Botão Solicitar Edição -->
                                                <button type="button" class="btn btn-primary btn-sm mx-1" style="width: 32px; height: 32px;" data-id="<?= $id ?>" title="Solicitar Edição">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Botão Solicitar Exclusão -->
                                                <button type="button" class="btn btn-danger btn-sm mx-1" style="width: 32px; height: 32px;" data-id="<?= $id ?>" title="Solicitar Exclusão">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhuma ação encontrada</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts da página -->
<?php echo view('scripts/acoes.php'); ?>