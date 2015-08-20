<?php
namespace Helpers;

class Quotes {

    public static function getRandomQuote() {
        $quotes = array(
            /* Management quotes */
            //      'Never argue with fools. They will lower you to their level and then beat you with experience',
            'Either you run the day or the day runs you.',
            'One may miss the mark by aiming too high or too low.',
            'If you\'ve got a talent, protect it. ',
            'One way to keep momentum going is to have constantly greater goals.',
            'Money won\'t buy happiness, but it will pay the salaries of a large research staff to study the problem.',
            'If God wanted us to bend over he\'d put diamonds on the floor.',
            'TV is chewing gum for the eyes. ',
            'First, solve the problem. Then, write the code.',
            'I\'m normally not a praying man, but if you\'re up there, please save me Superman.',
            'God made mosquitoes to make us slap ourselves!',
            'I like work. It fascinates me. I sit and look at it for hours.',
            'Adults are always asking kids what they want to be when they grow up, because they are looking for ideas.',
            'The bad news is time flies. The good news is you\'re the pilot.',
            'What I need is an exact list of specific unknown problems we might encounter.',
            'A man must be master of his hours and days, not their servant.',
            'Don\'t spend time beating on a wall, hoping to transform it into a door.',
            /* some more quotes */
            'If programmers deserve to be rewarded for creating innovative programs, by the same token they deserve to be punished if they restrict the use of these programs.',
            'The trouble with programmers is that you can never tell what a programmer is doing until it\'s too late.',
            'Debugging time increases as a square of the program\'s size.',
            /* humor */
            'There\'s one thing about baldness, it\'s neat.',
            'When you try to stand out of crowd, you will be pulled into another crowd.',
            'Sorry, I can\'t hangout. My uncle\'s cousin\'s sister in law\'s best friend\'s insurance agent\'s roommate\'s pet goldfish died. Maybe next time. ',
			'It\'s kind of fun to do the impossible. - Walt Disney',
        );

        return $quotes[array_rand($quotes)];
    }

}