<?php
/**
 * Squiz_Sniffs_PHP_DisallowSizeFunctionsInLoopsSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: DisallowSizeFunctionsInLoopsSniff.php,v 1.1 2008/04/07 01:14:00 squiz Exp $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Squiz_Sniffs_PHP_DisallowSizeFunctionsInLoopsSniff.
 *
 * Bans the use of size-based functions in loop conditions.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Squiz_Sniffs_PHP_DisallowSizeFunctionsInLoopsSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * An array of functions we don't want in the condition of loops.
     *
     * @return array
     */
    protected $forbiddenFunctions = array(
                                     'sizeof',
                                     'strlen',
                                     'count',
                                    );


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_WHILE, T_FOR);

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens       = $phpcsFile->getTokens();
        $openBracket  = $tokens[$stackPtr]['parenthesis_opener'];
        $closeBracket = $tokens[$stackPtr]['parenthesis_closer'];

        for ($i = ($openBracket + 1); $i < $closeBracket; $i++) {
            if ($tokens[$i]['code'] === T_STRING && in_array($tokens[$i]['content'], $this->forbiddenFunctions)) {
                $error = 'The use of '.$tokens[$i]['content'].'() inside a loop condition is not allowed. Assign the return value of '.$tokens[$i]['content'].'() to a variable and use the variable in the loop condition instead.';
                $phpcsFile->addError($error, $i);
            }
        }

    }//end process()


}//end class

?>
