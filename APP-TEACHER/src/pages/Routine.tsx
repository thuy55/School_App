import React, { useState, useEffect } from "react";
import { IonSelect, IonSelectOption, IonButton } from "@ionic/react";
import axios from "axios";

const MyComponent = () => {
  const [selectedValue, setSelectedValue] = useState("");
  const [semester, setSemester] = useState([] as any[]);
  const [course, setCourse] = useState([] as any[]);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_course = localStorage.getItem("id_course");
    var id_school = localStorage.getItem("id_school_teacher");
    const id_semester = localStorage.getItem("id_semester");
    const loginData = {
      token: x,
      id_course: id_course,
      id_school_teacher: id_school,
    };
    api
      .post("/scores_semester_teacher", loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (id_semester) {
            setSelectedValue(id_semester);
            // getListClass(id_semester, name_semester);
            setSemester(res.data.semester);
            setCourse(res.data.course);
          } 
          // else {
          //   setSemester(res.data.semester);
          //   setCourse(res.data.course);
          // }
        }
      })
      .catch((error) => {});
  }, []);

  useEffect(() => {
    // Thực hiện các thao tác khôi phục giá trị đã chọn từ lưu trữ (ví dụ: localStorage)
    const id_semester = localStorage.getItem("id_semester");
    if (id_semester) {
      setSelectedValue(id_semester);
    } 
  }, []);

  const handleSelectChange = (event: any) => {
    const value = event.target.value;
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_course = localStorage.getItem("id_course");
    var id_school = localStorage.getItem("id_school_teacher");
    const id_semester = localStorage.getItem("id_semester");
    const loginData = {
      token: x,
      id_course: id_course,
      id_school_teacher: id_school,
    };
    api
      .post("/scores_semester_teacher", loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (id_semester) {
            setSelectedValue(value);
            localStorage.setItem("id_semester", value);
            setSemester(res.data.semester);
            setCourse(res.data.course);
          } 
          // else {
          //   setSemester(res.data.semester);
          //   setCourse(res.data.course);
          // }
        }
      })

  };

  const handleReloadPage = () => {
    window.location.reload();
  };

  return (
    <div>
      {/* <IonSelect value={selectedValue} onIonChange={handleSelectChange}>
        <IonSelectOption value="option1">1</IonSelectOption>
        <IonSelectOption value="option2">2</IonSelectOption>
        <IonSelectOption value="option3">3</IonSelectOption>
      </IonSelect> */}
      <select
        className="select-name"
        color="primary"
        slot="start"
        // interface="popover"
        placeholder="HỌC KÌ"
        value={selectedValue}
        onChange={handleSelectChange}
        // onIonChange={(e: any) =>
        //   getListClass(e.target.value.id, e.target.value.name)
        // }
      >
        {semester.map((course, key) => {
          return (
            <option
              value={ course.name}
            
            >
              HỌC KÌ {course.name}
            </option>
          );
        })}
      </select>
      <IonButton onClick={handleReloadPage}>Reload Page</IonButton>
    </div>
  );
};

export default MyComponent;
