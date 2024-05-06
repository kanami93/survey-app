<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Cake\Core\Configure;
use Cake\Utility\Text;

class S3ClientComponent extends Component
{
    protected $s3;
    protected $s3_bucket;


    public function initialize(array $config):void
    {
        $this->s3 = new S3Client(Configure::read('S3.config'));
        $this->s3_bucket = Configure::read('S3.bucket');
    }

    /**
     * Uploading files
     * @param $file
     * @return mixed
     * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#putobject
     */
    public function putFile($file)
    {
        try {
            $filename = Text::uuid() . '_' . $file->getClientFilename();
            $result = $this->s3->putObject([
                'Bucket' => $this->s3_bucket,
                'Key' => $filename,
                'Body' => fopen($file->getStream()->getMetadata('uri'), 'r'),
//                'ACL' => 'public-read', // 適切なACLを設定します
            ]);

            return $result;
        } catch (S3Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getObject($key)
    {
        return $this->s3->getObjectUrl($this->s3_bucket, $key);
    }
}
