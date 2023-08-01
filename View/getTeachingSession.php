<?php
include("../Controller/LessonTimeController.php");
$LessonTimeController = new LessonTimeController();

include("../Controller/AuthenticationController.php");
$AuthenticationController = new AuthenticationController();

$postData = json_decode(file_get_contents("php://input"), true);

$auth = $AuthenticationController->AuthenticateToken($postData["token"]);

if ($auth != false) {	
	echo json_encode($LessonTimeController->GetTeachingSession($postData["lessonTime"]));
} else {
	echo "ERROR: Unauthorised.";
}


/*
echo
	'[
	[
		[
			{		
		"idStudent": "1",
				"name": "Jonáš",
		"surname": "Kalivoda",
		"activityValue": "0",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		],
		"note": "problémy s výslovností schwa, zájem o četbu fantasy žánru"
			},
			{
		"idStudent": "2",
				"name": "Tomáš",
		"surname": "Krabička",
		"activityValue": "1",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			}
		],
		[
			{
		"idStudent": "3",
				"name": "Jonáš",
		"surname": "Kalivoda",
		"activityValue": "2",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			},
			{
		"idStudent": "4",
				"name": "Tomáš",
		"surname": "Krabička",
		"activityValue": "3",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			}
		],
		[
			{
		"idStudent": "5",
				"name": "Jonáš",
		"surname": "Kalivoda",
		"activityValue": "4",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			},
			{
		"idStudent": "6",
				"name": "Tomáš",
		"surname": "Krabička",
		"activityValue": "5",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			}
		]
	],
	[
		[
			{
		"idStudent": "7",
				"name": "Jonáš",
		"surname": "Kalivoda",
		"activityValue": "6",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			},
			{
		"idStudent": "8",
				"name": "Tomáš",
		"surname": "Krabička",
		"activityValue": "7",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			}
		],
		[
			{
		"idStudent": "9",
				"name": "Jonáš",
		"surname": "Kalivoda",
		"activityValue": "8",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			},
			{
		"idStudent": "10",
				"name": "Tomáš",
		"surname": "Krabička",
		"activityValue": "9",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			}
		],
		[
			{
		"idStudent": "11",
				"name": "Jonáš",
		"surname": "Kalivoda",
		"activityValue": "5",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			},
			{
		"idStudent": "12",
				"name": "Tomáš",
		"surname": "Krabička",
		"activityValue": "5",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			}
		]
	],
	[
		[
			{
		"idStudent": "13",
				"name": "Jonáš",
		"surname": "Kalivoda",
		"activityValue": "5",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			},
			{
		"idStudent": "14",
				"name": "Tomáš",
		"surname": "Krabička",
		"activityValue": "5",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			}
		],
		[
			{
		"idStudent": "15",
				"name": "Jonáš",
		"surname": "Kalivoda",
		"activityValue": "5",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			},
			{
		"idStudent": "16",
				"name": "Tomáš",
		"surname": "Krabička",
		"activityValue": "5",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			}
		],
		[
			{
		"idStudent": "17",
				"name": "Jonáš",
		"surname": "Kalivoda",
		"activityValue": "5",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			},
			{
		"idStudent": "18",
				"name": "Tomáš",
		"surname": "Krabička",
		"activityValue": "5",
		"smallGrades": 
		[
			{
				"date": "13. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "14. 11. 2022",
				"isPlus": "0",
				"description": "Pozdní příchod" 
			},
			{
				"date": "18. 11. 2022",
				"isPlus": "1",
				"description": "Ústní zkoušení" 
			},
			{
				"date": "19. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			},
			{
				"date": "24. 11. 2022",
				"isPlus": "1",
				"description": "Práce v hodině" 
			}
		]
			}
		]
	],
	
	[
		[
			{
				"name": "Katedra",
				"isTeachersDesk": true
			}
		]
	]
]';*/