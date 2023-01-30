<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicController extends Controller
{
    function commencer($joueur = 'X')
    {
        $plateau = str_split('---------');
        return view('tic.jeu', ['plateau' => $plateau, 'joueur' => $joueur]);
    }
    function afficher($joueur, $plateau)
    {
        $plateau = str_split($plateau);
        return view('tic.jeu', ['plateau' => $plateau, 'joueur' => $joueur]);
    }
    function jouer($joueur, $plateau, $coup)
    {
        $plateau = str_split($plateau);
        $plateau[$coup] = $joueur;
        if ($this->estGagnant($plateau, $joueur)) {
            return redirect()->route('tic.gagnant', ['joueur' => $joueur]);
        }
        $opposant = $this->opposant($joueur);
        $plateau = $this->coupAuto($plateau, $opposant);
        if ($this->estGagnant($plateau, $opposant)) {
            return redirect()->route('tic.gagnant', ['joueur' => $opposant]);
        }
        
        return redirect()->route('tic.afficher', ['plateau' => implode('', $plateau), 'joueur' => $joueur]);
    }
    function opposant($joueur) {
        return ($joueur === 'X') ? 'O' : 'X';
    }
    function gagnant($joueur)
    {
        return view('tic.gagnant', ['joueur' => $joueur]);
    }
    function coupAuto($plateau, $joueur)
    {
        $coupGagnant = $this->trouverCoupGagnant($plateau, $joueur);
        if ($coupGagnant >= 0) {
            $plateau[$coupGagnant] = $joueur;
            return $plateau;
        }
        $opposant = $this->opposant($joueur);
        $coupBloquant = $this->trouverCoupGagnant($plateau, $opposant);
        if ($coupBloquant >= 0) {
            $plateau[$coupBloquant] = $joueur;
            return $plateau;
        }
        $nb = array_count_values($plateau)['-'];
        $pos = rand(0, $nb - 1);
        $curseur = 0;
        foreach ($plateau as $i => $case) {
            if ($case === '-') {
                if ($curseur === $pos) {
                    $plateau[$i] = $joueur;
                    return $plateau;
                }
                $curseur += 1;
            }
        }
        return $plateau;
    }
    function estGagnant($plateau, $joueur)
    {
        return
            $plateau[0] === $joueur && $plateau[1] === $joueur && $plateau[2] === $joueur ||
            $plateau[3] === $joueur && $plateau[4] === $joueur && $plateau[5] === $joueur ||
            $plateau[6] === $joueur && $plateau[7] === $joueur && $plateau[8] === $joueur ||
            $plateau[0] === $joueur && $plateau[3] === $joueur && $plateau[6] === $joueur ||
            $plateau[1] === $joueur && $plateau[4] === $joueur && $plateau[7] === $joueur ||
            $plateau[2] === $joueur && $plateau[5] === $joueur && $plateau[8] === $joueur ||
            $plateau[0] === $joueur && $plateau[4] === $joueur && $plateau[8] === $joueur ||
            $plateau[2] === $joueur && $plateau[4] === $joueur && $plateau[6] === $joueur;
    }
    function trouverCoupGagnant($plateau, $joueur)
    {
        foreach ($plateau as $position => $case) {
            if ($case === "-") {
                $plateau[$position] = $joueur;
                if ($this->estGagnant($plateau, $joueur)) {
                    return $position;
                }
                $plateau[$position] = '-';
            }
        }
        return -1;
    }
}
