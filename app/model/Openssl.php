<?php 
declare (strict_types = 1);
namespace app\model;

class Openssl
{
    private $pathData = '';
    private $pathKey = '';
    private $pathEncrypted = '';
    private $pathDecrypted = '';
    private $pathSignature = '';

    public function __construct() {
        $root = getcwd() . DIRECTORY_SEPARATOR 
        . 'app' . DIRECTORY_SEPARATOR 
        . 'data' . DIRECTORY_SEPARATOR;

        $this->pathData = $root
        . 'data' . DIRECTORY_SEPARATOR;

        $this->pathKey = $root
        . 'key' . DIRECTORY_SEPARATOR;

        $this->pathEncrypted = $root
        . 'encrypted' . DIRECTORY_SEPARATOR;

        $this->pathDecrypted = $root
        . 'decrypted' . DIRECTORY_SEPARATOR;

        $this->pathSignature = $root
        . 'signature' . DIRECTORY_SEPARATOR;
    }

    /**
     * encript data with public key
     * @param public public key filename 
     * @param data original data filename
     */
    public function encript($public, $data): object {
        $cmd = 'openssl rsautl -encrypt -inkey '
        . $this->pathKey
        . escapeshellcmd($public)
        . ' -pubin -in '
        . $this->pathData
        . escapeshellcmd($data)
        . ' -out '
        . $this->pathEncrypted
        . escapeshellcmd($data) . '.encrypted';
        $r = shell_exec($cmd);
        return (object) [
            'cmd' => $cmd,
            'exe' => $r,
            'ok' => $r == null && \file_exists(
                $this->pathEncrypted
                . escapeshellcmd($data) . '.encrypted'
            )
        ];
    }

    /**
     * decrypt data with public key
     * @param public public key filename 
     * @param data original data filename
     */
    public function decrypt($public, $data): object {
        $cmd = 'openssl rsautl -inkey '
        . $this->pathKey
        . escapeshellcmd($public)
        . ' -pubin -in '
        . $this->pathEncrypted
        . escapeshellcmd($data) . '.encrypted'
        . ' > '
        . $this->pathDecrypted
        . escapeshellcmd($data) . '.decrypted';
        $r = shell_exec($cmd);
        return (object) [
            'cmd' => $cmd,
            'exe' => $r,
            'ok' => $r == null && \file_exists(
                $this->pathDecrypted
                . escapeshellcmd($data) . '.decrypted'
            )
        ];
    }

    /**
     * Verify Digital Signature
     * @param public public key filename 
     * @param data original data filename
     */
    public function verify($public, $data): object {
        $cmd = 'openssl dgst -sha256 -verify '
        . $this->pathKey
        . escapeshellcmd($public)
        . ' -signature '
        . $this->pathSignature
        . escapeshellcmd($data) . '.sha256'
        . ' '
        . $this->pathData
        . escapeshellcmd($data);
        $r = shell_exec($cmd);
        return (object) [
            'cmd' => $cmd,
            'exe' => $r,
            'ok' => $r == "Verified OK\n"
        ];
    }
}
