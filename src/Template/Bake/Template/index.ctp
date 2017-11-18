<%
use Cake\Utility\Inflector;

$fields = collection($fields)
  ->filter(function($field) use ($schema) {
    return !in_array($schema->columnType($field), ['binary', 'text']);
  })
  ->take(7);
%>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <%= $pluralHumanName %>
  </h1>
</section>
<div class="col-md-2">
    <?=
    $this->Html->link(
        $this->Html->tag('i', '', ['class' => 'fa fa-plus']). __('New'),
        ['action' => 'add'],
        [
            'class'=>'btn btn-app bg-olive',
            'escape' => false
        ]
    );
    ?>
</div>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= __('List of') ?> <%= $pluralHumanName %></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-hover table-striped table-condensed dataTable">
            <thead>
              <tr>
<%  foreach ($fields as $field):
if (!in_array($field, ['created', 'modified', 'updated'])) :%>
                <th><?= $this->Paginator->sort('<%= $field %>') ?></th>
<%  endif; %>
<%  endforeach; %>
                <th><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
              <tr>
<%  foreach ($fields as $field) {
    if (!in_array($field, ['created', 'modified', 'updated'])) {
    $isKey = false;
    if (!empty($associations['BelongsTo'])) {
    foreach ($associations['BelongsTo'] as $alias => $details) {
      if ($field === $details['foreignKey']) {
        $isKey = true;
%>
                <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
<%
          break;
        }
      }
    }

    if ($isKey !== true) {
      if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
%>
                <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
      } else {
%>
                <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
      }
    }
    }
  }
  $pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
                  <td class="actions">
                      <div class="btn-group">
                          <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown"><?= __('Actions')?>
                              <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                              <li> <?= $this->Html->link(__('View'), ['action' => 'view', <%= $pk %>]) ?></li>
                              <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', <%= $pk %>]) ?>
                              </li>
                              <li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', <%= $pk %>], [
                                  'confirm' => __('Are you sure you want to delete # {0}?',  <%= $pk %>),
                                  'class' => 'btn-danger',
                                  'style' => 'color: white;'
                                  ]) ?>
                              </li>
                          </ul>
                      </div>
                  </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <ul class="pagination pagination-sm no-margin pull-right">
            <?php echo $this->Paginator->numbers(); ?>
          </ul>
        </div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
