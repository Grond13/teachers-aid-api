<?php

include "../Model/LessonTimeModel.php";
class LessonTimeController
{
    private $LessonTimeModel;
    public function __construct()
    {
        $this->LessonTimeModel = new LessonTimeModel();        
    }

    function GetTimetable($idTeacher){
        $result = $this->LessonTimeModel->GetTimeTable($idTeacher);
        $this->LessonTimeModel->unsetConn();
        return $result;
    }
    
    function updateLessonTime($LessonTime){
        $result = $this->LessonTimeModel->updateLessonTime($LessonTime);
        $this->LessonTimeModel->unsetConn();
        return $result;
    }

    function insertLessonTime($LessonTime){
        $result = $this->LessonTimeModel->insertLessonTime($LessonTime);
        $this->LessonTimeModel->unsetConn();
        return $result;
    }

    function deleteLessonTime($idLessonTime){
        $result = $this->LessonTimeModel->deleteLessonTime($idLessonTime);
        $this->LessonTimeModel->unsetConn();
        return $result;
    }

    function getTeachingSession($idLessonTime){              
        $studentInfos = $this->LessonTimeModel->getTeachingSession($idLessonTime);
        
        $studentInfos = $this->LessonTimeModel->addRatings($idLessonTime, $studentInfos);

        $result = $this->fillSeats($this->LessonTimeModel->getLayout($idLessonTime), $studentInfos);                 
        $this->LessonTimeModel->unsetConn();
        return $result;
    }

    private function addRatings($students, $ratings){

        return $students;
    }

    private function fillSeats($classroomData, $studentsData) {
        $combinedData = array();
    
        $studentMap = array();
        foreach ($studentsData as $student) {
            $idSeat = $student['idSeat'];
            $studentMap[$idSeat] = $student;
        }
    
        foreach ($classroomData as $seat) {
            $idSeat = $seat['idSeat'];
            if (isset($studentMap[$idSeat])) {
                $combinedData[] = array_merge($seat, $studentMap[$idSeat]);
            } else {
                $combinedData[] = array_merge($seat, array(
                    'idStudent' => null,
                    'name' => null,
                    'surname' => null,
                    'activityRating' => null,
                    'note' => null,
                    'smallGrades' => null
                ));
            }
        }
    
        $groupedByRow = array();
        foreach ($combinedData as $item) {
            $row = $item['row'];
            $idDesk = $item['idDesk'];
            $groupedByRow[$row][$idDesk][] = $item;
        }
            
        $result = array();
        foreach ($groupedByRow as $row) {
            $result[] = array_values($row);
        }
    
        $result = array_values($result);
    
        return $result;
    }
    
}

