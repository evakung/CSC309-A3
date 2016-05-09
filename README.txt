CSC309 - CONNECT 4 
Eva (FanYi) Kung, 998137573, g3ekungg 

--------------------------------------------------------------------------------------------------------------------
Note: In order to run this program successfully,  the Securimage project library must be saved/imported into the root directory
where the server runs on (In this case in the htdocs folder). 

Welcome to EvaKungs Connect 4 game! 


When you enter the website, you are asked to log in or create a new account. The game requires you to register or to hold an 
existing account in order for users to play against each other. No GUEST uption is available. Upon logging in, users are able to
view a list of users that are currently in the lobby waiting or open for invitation/accepting requests. Otherwise they may be given options
to log out of the game or to change their passwords.  

Upon invitation:
If you invite someone to the game, the opponent will have the option to reject or accept the game invitation. 
If accepted, both parties will be brought into the connect4 game arena (called connect-a-rena!). The game is done by turns. The 
opposing party will not be able to play or put a new chip at their turn unless you have finished with your current turn. The process is
the same after you have accepted the other parties invitation to play a game of Connect 4! Users may choose to play however many games they want. 

About the game board:
The board is a modified version from the classic connect 4 gameboard. Each empty slot is represented with skyblue framed borders of the array
of the board implemented in board.php. Each turn when user clicks on the spot to throw down their chip, they are replaced with the circles
with the corresponding colors that is listed on the top of the game once you enter the arena. 

The implementation of the boardgame is done through the Board Controller. I had used the already given getmsg/postmsg functionalities that 
had given the application a instant messaging feature. But instead, I had used the given functions and expanded on the board. What I did was pass
the board values as strings when transferring the values back and forth, then exploded it to as an array. Then there, I kept track if there was a 
winning connect4 each time a "message" was entered. It is a simple made connect4 board with the all the functionalities getting checked through each call.
Additional functions were not needed. The board was just appeneding string values as the pieces.