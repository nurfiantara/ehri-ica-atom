<?php

/**
 * Symfony Coding Standard.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Jack Bates <ms419@freezone.co.uk>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: SymfonyCodingStandard.php 68 2007-09-21 22:46:08Z jablko $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 * @link      http://trac.symfony-project.com/trac/wiki/CodingStandards
 */

if (class_exists('PHP_CodeSniffer_Standards_CodingStandard', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_CodingStandard not found');
}

/**
 * Symfony Coding Standard.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Jack Bates <ms419@freezone.co.uk>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 * @link      http://trac.symfony-project.com/trac/wiki/CodingStandards
 */
class PHP_CodeSniffer_Standards_Symfony_SymfonyCodingStandard extends PHP_CodeSniffer_Standards_CodingStandard
{
    /**
     * Return a list of external sniffs to include with this standard.
     *
     * The Symfony standard uses some generic sniffs.
     *
     * @return array
     */
    public function getIncludedSniffs()
    {
        return array(
	    //'Generic/Sniffs/Formatting/MultipleStatementAlignmentSniff.php',
	    //'Generic/Sniffs/Functions/OpeningFunctionBraceBsdAllmanSniff.php',
	    //'Generic/Sniffs/NamingConventions/UpperCaseConstantNameSniff.php',
	    //'Generic/Sniffs/PHP/LowerCaseConstantSniff.php',
	    'Generic/Sniffs/PHP/DisallowShortOpenTagSniff.php',
	    'Generic/Sniffs/WhiteSpace/DisallowTabIndentSniff.php',
	    'Generic/Sniffs/Formatting/SpaceAfterCastSniff.php',
	    //'Squiz/Sniffs/Comments/InlineCommentSniff.php',
	    'Squiz/Sniffs/ControlStructures/ElseIfDeclarationSniff.php',
	    'Squiz/Sniffs/ControlStructures/ForEachLoopDeclarationSniff.php',
	    'Squiz/Sniffs/ControlStructures/ForLoopDeclarationSniff.php',

	    // Don't apply to templates
	    //'Squiz/Sniffs/ControlStructures/InlineControlStructureSniff.php',
	    'Squiz/Sniffs/ControlStructures/LowercaseDeclarationSniff.php',
	    'Squiz/Sniffs/Strings/ConcatenationSpacingSniff.php');
    }
}
