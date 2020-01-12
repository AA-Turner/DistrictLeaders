<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Document;
use App\Model\Entity\DocumentEdition;
use App\Model\Entity\DocumentVersion;
use App\Model\Entity\FileType;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;
use Josbeir\Filesystem\FilesystemAwareTrait;
use PhpParser\Comment\Doc;

/**
 * Documents Model
 *
 * @property \App\Model\Table\DocumentTypesTable&\Cake\ORM\Association\BelongsTo $DocumentTypes
 * @property \App\Model\Table\DocumentVersionsTable&\Cake\ORM\Association\HasMany $DocumentVersions
 *
 * @method \App\Model\Entity\Document get($primaryKey, $options = [])
 * @method \App\Model\Entity\Document newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Document[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Document|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Document saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Document patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Document[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Document findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @mixin \App\Model\Behavior\CaseableBehavior
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \App\Model\Entity\Document[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 */
class DocumentsTable extends Table
{
    use FilesystemAwareTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('documents');
        $this->setDisplayField('document');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');
        $this->addBehavior('Search.Search');

        $this->addBehavior('Caseable', [
            'case_columns' => [
                Document::FIELD_DOCUMENT => 't',
            ],
        ]);

        $this->belongsTo('DocumentTypes', [
            'foreignKey' => 'document_type_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DocumentVersions', [
            'foreignKey' => 'document_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer(Document::FIELD_ID)
            ->allowEmptyString(Document::FIELD_ID, null, 'create');

        $validator
            ->scalar(Document::FIELD_DOCUMENT)
            ->maxLength(Document::FIELD_DOCUMENT, 255)
            ->notEmptyString(Document::FIELD_DOCUMENT)
            ->add(Document::FIELD_DOCUMENT, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['document']));
        $rules->add($rules->existsIn(['document_type_id'], 'DocumentTypes'));

        return $rules;
    }

    /**
     * @param array $postData Post Request Data (file upload array)
     * @param \App\Model\Entity\Document $documentEntity The Document Entity
     * @param string $fileSystem The configured Filesystem Name
     *
     * @return \Cake\Datasource\EntityInterface|bool
     */
    public function uploadDocument($postData, $documentEntity, $fileSystem = 'default')
    {
        if (!key_exists('uploadedFile', $postData)) {
            return false;
        }

        /** @var \Cake\Datasource\EntityInterface $fileEntity */
        $fileEntity = $this->getFilesystem($fileSystem)->upload($postData['uploadedFile']);

        $mime = $postData['uploadedFile']['type'] ?? $fileEntity->get(FileType::FIELD_MIME);

        try {
            $fileType = $this->DocumentVersions->DocumentEditions->FileTypes->find()->where([
                FileType::FIELD_MIME => $mime,
            ])->firstOrFail();
        } catch (RecordNotFoundException $exception) {
            return false;
        }

        $documentName = explode('.', $fileEntity->get(DocumentEdition::FIELD_FILENAME))[0];
        $documentName = Inflector::humanize($documentName);

        $documentData = [
            Document::FIELD_DOCUMENT => $documentName,
            Document::FIELD_DOCUMENT_TYPE_ID => $postData[Document::FIELD_DOCUMENT_TYPE_ID],
            Document::FIELD_DOCUMENT_VERSIONS => [
                [
                    DocumentVersion::FIELD_VERSION_NUMBER => 1,
                    DocumentVersion::FIELD_DOCUMENT_EDITIONS => [
                        [
                            DocumentEdition::FIELD_FILENAME => $fileEntity->get(DocumentEdition::FIELD_FILENAME),
                            DocumentEdition::FIELD_MD5_HASH => $fileEntity->get('hash'),
                            DocumentEdition::FIELD_FILE_TYPE_ID => $fileType->get(FileType::FIELD_ID),
                            DocumentEdition::FIELD_FILE_PATH => $fileEntity->get('path'),
                            DocumentEdition::FIELD_SIZE => $fileEntity->get(DocumentEdition::FIELD_SIZE),
                        ],
                    ],
                ],
            ],
        ];

        $document = $this->patchEntity($documentEntity, $documentData, ['associated' => ['DocumentVersions.DocumentEditions']]);

        return $this->save($document);
    }
}
