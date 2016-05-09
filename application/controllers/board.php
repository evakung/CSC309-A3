<?php

class Board extends CI_Controller {
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	session_start();
    } 
          
    public function _remap($method, $params = array()) {
	    	// enforce access control to protected functions	
    		
    		if (!isset($_SESSION['user']))
   			redirect('account/loginForm', 'refresh'); //Then we redirect to the index page again
 	    	
	    	return call_user_func_array(array($this, $method), $params);
    }
    
    
    function index() {
		$user = $_SESSION['user'];
    		    	
	    	$this->load->model('user_model');
	    	$this->load->model('invite_model');
	    	$this->load->model('match_model');
	    	
	    	$user = $this->user_model->get($user->login);

	    	$invite = $this->invite_model->get($user->invite_id);
	    	
	    	if ($user->user_status_id == User::WAITING) {
	    		$invite = $this->invite_model->get($user->invite_id);
	    		$otherUser = $this->user_model->getFromId($invite->user2_id);
	    	}
	    	else if ($user->user_status_id == User::PLAYING) {
	    		$match = $this->match_model->get($user->match_id);
	    		if ($match->user1_id == $user->id)
	    			$otherUser = $this->user_model->getFromId($match->user2_id);
	    		else
	    			$otherUser = $this->user_model->getFromId($match->user1_id);
	    	}
	    	
	    	$data['user']=$user;
	    	$data['otherUser']=$otherUser;
	    	
	    	switch($user->user_status_id) {
	    		case User::PLAYING:	
	    			$data['status'] = 'playing';
	    			break;
	    		case User::WAITING:
	    			$data['status'] = 'waiting';
	    			break;
	    	}
	    	
		$this->load->view('match/board',$data);
    }

 	function postBoard() {
 		//STARTER CODE
 		$this->load->library('form_validation');
 		$this->form_validation->set_rules('msg', 'Message', 'required');
 		
 		if ($this->form_validation->run() == TRUE) {
 			$this->load->model('user_model');
 			$this->load->model('match_model');

 			$user = $_SESSION['user'];
 			 
 			$user = $this->user_model->get($user->login);
 			if ($user->user_status_id != User::PLAYING) {	
				$errormsg="Not in PLAYING state";
 				goto error;
 			}
 			
 			$match = $this->match_model->get($user->match_id);			
 			
 			$msg = $this->input->post('msg');
 			
 			//Adding onto the board either self vs other
 			if ($match->user1_id == $user->id)  {
 				
 				$boardgame = $match->board_state;
 				$boardgame .= '1';
 				
 				if ( strlen($msg) == 1)
 				{
 					$boardgame .= '0';
 				}
 				
 				$boardgame .= $msg;
 				$boardgame .= '.';
 				$this->match_model->updateBoardGame($match->id, $boardgame);
 				
 				$msg = $match->u1_msg == ''? $msg :  $match->u1_msg . "\n" . $msg;
 				$this->match_model->updateMsgU1($match->id, $msg);
 			}
 			else 
 			{
 				$boardgame = $match->board_state;
 				$boardgame .= '2';
 				
 				if ( strlen($msg) == 1)
 				{
 					$boardgame .= '0';
 				}
 				
 				$boardgame .= $msg;
 				$boardgame .= '.';
 				$this->match_model->updateBoardGame($match->id, $boardgame);
 				
 				$msg = $match->u2_msg == ''? $msg :  $match->u2_msg . "\n" . $msg;
 				$this->match_model->updateMsgU2($match->id, $msg);
 			}

 			$match = $this->match_model->get($user->match_id);			
 			$boardgame = substr($match->board_state, 0, count($match->board_state)-2);
 			$partitioned_board = explode('.',$boardgame); //splits the board
 				
 			$p1_values = array();
 			$p2_values = array();
 			$winner = array();
 			
 			//$this->getWinner($partitioned_board);
 			
 			//Need to find if the board has a connect4
 			if( count($partitioned_board) > 3)
 			{
 				foreach($partitioned_board as $column) //searching up the cols/rows
 				{ 
 					if ($column[0] ==1)
 					{
 						$digit_one = $column[1];
 						$digit_two =$column[2];
 						$index = 10 * $digit_one + $digit_two;
 						array_push($p1_values, $index);
 					}
 					else if($column[0]==2)
 					{
 						$digit_one = $column[1];
 						$digit_two =$column[2];
 						$index = 10* $digit_one + $digit_two;
 						array_push($p2_values,$index);
 					};
 				};
 				if ($match->user1_id == $user->id) 
 				{
 					$all_values = $p1_values;
 				}
 				else 
 				{
 					$all_values = $p2_values;
 				};
 				$temp = $all_values;

 				//checks row
 				foreach ($temp as $slot)
 				{
 					if (in_array($slot-1,$temp))
 					{
 						if (in_array($slot-2,$temp))
 						{
 							if (in_array($slot-3,$temp))
 							{
 								array_push($winner,$slot);
 								array_push($winner,$slot-1);
 								array_push($winner,$slot-2);
 								array_push($winner,$slot-3);
 							}
 						}
 					}
 				};
 				
 				//checks up/down
 				foreach ($temp as $slot)
 				{
 					if (in_array($slot-6,$temp))
 					{
 						if (in_array($slot-12,$temp))
 						{
 							if (in_array($slot-18,$temp))
 							{
 								array_push($winner,$slot);
 								array_push($winner,$slot-6);
 								array_push($winner,$slot-12);
 								array_push($winner,$slot-18);
 							}
 						}
 					}
 				};
 				
 				//check diagonal
 				foreach ($temp as $slot)
 				{
 					if (in_array($slot-5,$temp))
 					{
 						if (in_array($slot-10,$temp))
 						{
 							if (in_array($slot-15,$temp))
 							{
 								array_push($winner,$slot);
 								array_push($winner,$slot-5);
 								array_push($winner,$slot-10);
 								array_push($winner,$slot-15);
 							}
 						}
 					}
 				};
 				
 				//checks diagonal
 				foreach ($temp as $slot)
 				{
 					if (in_array($slot-7,$temp))
 					{
 						if (in_array($slot-14,$temp))
 						{
 							if (in_array($slot-21,$temp))
 							{
 								array_push($winner,$slot);
 								array_push($winner,$slot-7);
 								array_push($winner,$slot-14);
 								array_push($winner,$slot-21);
 							}
 						}
 					}
 				};
 			};
 			
 			//STARTER CODE
 			if ( count($winner) == 4 )
 			{
 				echo json_encode('youWon');
 			}
 			else
 			{
 				echo json_encode('success');
 			}
 			return;
 		}
		
 		$errormsg="Missing argument";
		error:
			echo json_encode(array('status'=>'failure','message'=>$errormsg));
 	}
 
 	
	function getBoard() {
		//STARTER CODE
		$this->load->model('user_model');
 		$this->load->model('match_model');
 			
 		$user = $_SESSION['user'];
 		 
 		$user = $this->user_model->get($user->login);
 		if ($user->user_status_id != User::PLAYING) {	
 			$errormsg="Not in PLAYING state";
 			goto error;
 		}
 		// start transactional mode  
 		$this->db->trans_begin();

 		$match = $this->match_model->getExclusive($user->match_id);			

 		
 		
 		//To find a winning row in the board
 		$boardgame = substr($match->board_state, 0, count($match->board_state)-2);
 		$partitioned_board= explode('.',$boardgame);
 		
 		$p1_values =array();
 		$p2_values =array();
 		$winner = array();
 		
 		if( count($partitioned_board) > 3)
 		{
 			foreach($partitioned_board as $column)
 			{
				if ($column[0] ==1)
				{
					$digit_one = $column[1];
					$digit_two =$column[2];
					$index = 10* $digit_one + $digit_two;
					array_push($p1_values,$index);
				}
				else if($column[0]==2)
				{
					$digit_one = $column[1];
					$digit_two =$column[2];
					$index = 10* $digit_one + $digit_two;
					array_push($p2_values,$index);
				};
			};
			if ($match->user1_id == $user->id) 
			{
				$all_values = $p2_values;
			}
			else 
			{
				$all_values = $p1_values;
			};
			
 			$temp = $all_values;
 		
 			
 			//checks if its in a row
 			foreach ($temp as $slot)
 			{
				if (in_array($slot-1,$temp))
				{
					if (in_array($slot-2,$temp))
					{
						if (in_array($slot-3,$temp))
						{
							array_push($winner,$slot);
							array_push($winner,$slot-1);
							array_push($winner,$slot-2);
							array_push($winner,$slot-3);
						}
					}
				}
 			};
 			
 			//checks up/down
 			foreach ($temp as $slot)
 			{
				if (in_array($slot-6,$temp))
				{
					if (in_array($slot-12,$temp))
					{
						if (in_array($slot-18,$temp))
						{
							array_push($winner,$slot);
							array_push($winner,$slot-6);
							array_push($winner,$slot-12);
							array_push($winner,$slot-18);
						}
					}
				}
 			};
 			
 			//checks diagonal
		 	foreach ($temp as $slot)
		 	{
				if (in_array($slot-5,$temp))
				{
					if (in_array($slot-10,$temp))
					{
						if (in_array($slot-15,$temp))
						{
							array_push($winner,$slot);
							array_push($winner,$slot-5);
							array_push($winner,$slot-10);
							array_push($winner,$slot-15);
						}
					}
				}
		 	};
		 	
		 	//checks diagonal
 		 	foreach ($temp as $slot)
 		 	{
				if (in_array($slot-7,$temp))
				{
					if (in_array($slot-14,$temp))
					{
						if (in_array($slot-21,$temp))
						{
							array_push($winner,$slot);
							array_push($winner,$slot-7);
							array_push($winner,$slot-14);
							array_push($winner,$slot-21);
						}
					}
				}
 		 	};
 		};

 		
 		//STARTER CODE
 		if ($match->user1_id == $user->id) 
 		{
			$msg = $match->u2_msg;
 			$this->match_model->updateMsgU2($match->id,"");	
 		}
 		else 
 		{
 			$msg = $match->u1_msg;
 			$this->match_model->updateMsgU1($match->id,"");
 		}

 		if ($this->db->trans_status() === FALSE) 
 		{
 			$errormsg = "Transaction error";
 			goto transactionerror;
 		}
 		
 		// if all went well commit changes
 		$this->db->trans_commit();
 		
 		if ( count($winner) == 4 )
 		{
			echo json_encode(array('status'=>'otherWon','message'=>$msg, 'winner'=>$winner));
		}
		else
		{
			echo json_encode(array('status'=>'success','message'=>$msg ));
		}
		return;
		
		transactionerror:
		$this->db->trans_rollback();
		
		error:
		echo json_encode(array('status'=>'failure','message'=>$errormsg));
 	}

 	
 	function gameSetWin(){
 		$this->load->model('match_model');
 		$this->load->model('user_model');
 		
 	 	$user = $_SESSION['user'];
 		 
 		$user = $this->user_model->get($user->login);
 		if ($user->user_status_id != User::PLAYING) {	
 			$errormsg="Not in PLAYING state";
 			goto error;
 		}
 		
 		$match = $this->match_model->get($user->match_id);
 		
 		if($user->id == $match->user1_id)
 		{
 			$this->match_model->updateStatus($user->match_id, Match::U1WON);
 		}
 		else
 		{
 			$this->match_model->updateStatus($user->match_id, Match::U2WON);
 		}
 		return;
 		
 		error:
 			echo json_encode(array('status'=>'failure','message'=>$errormsg));
 	}
 	
 	
 	
 	function getWinner($partitioned_board){
 		
 	}
 }

