<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 * @var mixed $documentTypes
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'Documents');

?>
<?= $this->Form->create($document, ['enctype' => 'multipart/form-data']) ?>
<fieldset>
    <?php
        echo $this->Form->control('uploadedFile', ['type' => 'file']);
        echo $this->Form->control('document_type_id', ['options' => $documentTypes]);
    ?>
</fieldset>
