<p id="msg"></p>

<div class="row">
    <table class="table table-responsive table-hovered" id="tbld">

    </table>
    <?php if (isset($productos)):  
        $a = (isset($aumenta)) ? $aumenta : 1;
        ?>
    <?php foreach ($productos as $row): ?>
    <tr>
        <td><?php echo $row->codproducto; ?></td>
        <td><?php echo $row->descripcion; ?></td>
        <td><?php echo $row->paisorigen ?></td>

    </tr>
    <?php endforeach ?>
    <?php endif ?>
</div>
</div>