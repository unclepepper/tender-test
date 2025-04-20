<?php

declare(strict_types=1);

namespace App\Common\Parse;

use Exception;


final class ParseCSVFile extends AbstractParseFile
{
    const string SEPARATOR = ',';

    /**
     * @return string[]
     * @throws Exception
     */
    public function parse(string $nameFile): array
    {
        $path = $this->kernel->getProjectDir().$nameFile;

        if(!file_exists($path))
        {
            throw new Exception('Cannot open file');
        }

        if(($handle = fopen($path, 'r')) !== false)
        {
            if(($header = fgetcsv($handle, 1000, self::SEPARATOR)) !== false)
            {

                while(($row = fgetcsv($handle, 1000, self::SEPARATOR)) !== false)
                {

                    if(count($header) !== count($row))
                    {
                        continue;
                    }

                    $this->data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        else
        {
            throw new Exception('File not found');
        }

        return $this->data;
    }

}
