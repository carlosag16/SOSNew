<tbody>
    <?php while($dados2 = mysqli_fetch_array($result)){?>
        <?php $i++;?>
        <tr class="match<?php echo $i; ?>">
            <th>    </th>
            <td><input type="checkbox" value="<?php echo $dados2['agd_id'];?>" name="list_check[]"></td>
        </tr>
        <tr class="match<?php echo $i; ?>">
            <th>Matrícula</th>
            <td><?php echo $dados2['agd_matricula']; ?></td>
        </tr>
        <tr class="match<?php echo $i; ?>">
            <th>Nome</th>
            <td><?php echo $dados2['agd_nome']; ?></td>
        </tr>
        <tr class="match<?php echo $i; ?>">
            <th>E-mail</th>
            <td><?php echo $dados2['agd_email']; ?></td>
        </tr>
        <tr class="match<?php echo $i; ?>">
            <th>Telefone</th>
            <td><?php echo $dados2['agd_telefone']; ?></td>                          
        </tr>
        <tr class="match<?php echo $i; ?>">
            <th>Data</th>				  
            <td><?php echo date('d/m/Y', strtotime($dados2['agd_data'])); ?></td> 
        </tr>

        <tr class="match<?php echo $i; ?>">				  
            <th>Horário</th>
            <td><?php echo DBReadOne('hor_horarios','hor_valor',"WHERE hor_id = {$dados2['hor_id']}"); ?></td> 
        </tr>

        <tr class="match<?php echo $i; ?>">				  
            <th>Bibliotecário(a)</th>
            <td><?php echo DBReadOne('ser_servidores','ser_nome',"WHERE ser_id = {$dados2['ser_id']}"); ?></td> 
        </tr>

        <tr class="match<?php echo $i; ?>">				  
            <th>Curso/Programa</th>
            <td><?php echo $dados2['agd_curso_programa']; ?></td>
        </tr>

        <tr class="match<?php echo $i; ?>">				  
            <th>Criado</th>
            <td><?php echo date('d/m/Y', strtotime($dados2['agd_criada'])); ?></td>
        </tr>
    
        <tr class="match<?php echo $i; ?>">				  
            <th>Compareceu</th>
            <td><?php if($_SESSION['concluidos']==1){ if($dados['agd_nao_compareceu'] == 0){ echo "Sim";} else {echo "Não";} } ?></td>
        </tr>
    
    <?php } ?>
</tbody>