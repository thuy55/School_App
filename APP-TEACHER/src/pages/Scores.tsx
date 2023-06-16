import {
  IonAccordion,
  IonAccordionGroup,
  IonButton,
  IonButtons,
  IonCard,
  IonCardContent,
  IonCol,
  IonContent,
  IonFab,
  IonFabButton,
  IonGrid,
  IonHeader,
  IonIcon,
  IonInput,
  IonItem,
  IonLabel,
  IonList,
  IonMenuButton,
  IonModal,
  IonPage,
  IonRow,
  IonSearchbar,
  IonSelect,
  IonSelectOption,
  IonTitle,
  IonToolbar,
  createAnimation,
  useIonAlert,
} from "@ionic/react";
import {
  addOutline,
  closeOutline,
  saveOutline,
  starSharp,
} from "ionicons/icons";

import "./Scores.css";
import { useEffect, useRef, useState } from "react";
import axios from "axios";

const OpinionDetail: React.FC = () => {
  const [presentAlert] = useIonAlert();
  const modal = useRef<HTMLIonModalElement>(null);

  function dismiss() {
    modal.current?.dismiss();
  }

  const enterAnimation = (baseEl: HTMLElement) => {
    const root = baseEl.shadowRoot;

    const backdropAnimation = createAnimation()
      .addElement(root?.querySelector("ion-backdrop")!)
      .fromTo("opacity", "0.01", "var(--backdrop-opacity)");

    const wrapperAnimation = createAnimation()
      .addElement(root?.querySelector(".modal-wrapper")!)
      .keyframes([
        { offset: 0, opacity: "0", transform: "scale(0)" },
        { offset: 1, opacity: "0.99", transform: "scale(1)" },
      ]);

    return createAnimation()
      .addElement(baseEl)
      .easing("ease-out")
      .duration(500)
      .addAnimation([backdropAnimation, wrapperAnimation]);
  };

  const leaveAnimation = (baseEl: HTMLElement) => {
    return enterAnimation(baseEl).direction("reverse");
  };

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
            getListClass(id_semester);
            setSemester(res.data.semester);
            setCourse(res.data.course);
          } else {
            setSemester(res.data.semester);
            setCourse(res.data.course);
          }
        }
      })
      .catch((error) => {});
  }, []);

  const [clas, setClas] = useState([] as any[]);
  function getListClass(e: any) {
    if (e && e.target && e.target.value) {
      var value = e.target.value;
      // Tiếp tục xử lý dữ liệu...
    }

    localStorage.setItem("id_semester", e);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_semester = localStorage.getItem("id_semester");
    var id_course = localStorage.getItem("id_course");
    var id_class_diagram = localStorage.getItem("id_class_diagram");
    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
      id_semester: id_semester,
    };
    api
      .post(`/scores_class_teacher`, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (id_class_diagram) {
            setSelectedValue1(id_class_diagram);
            getSubject(id_class_diagram);
            setClas(res.data.class);
            setSubject([]);
          } else {
            setSelectedValue(value);
            setClas(res.data.class);
          }
        }
      })
      .catch((error) => {});
  }

  const [subject, setSubject] = useState([] as any[]);
  function getSubject(e: any) {
    if (e && e.target && e.target.value) {
      var value = e.target.value;
      // Tiếp tục xử lý dữ liệu...
    }
    // localStorage.removeItem("id_class_diagram");
    localStorage.setItem("id_class_diagram", e);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");
    var id_class_diagram = localStorage.getItem("id_class_diagram");
    var id_assigning_teachers = localStorage.getItem("id_assigning_teachers");
    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
      id_class_diagram: id_class_diagram,
    };
    api
      .post(`/scores_subject_teacher/` + id_class_diagram, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (id_assigning_teachers) {
            setSelectedValue2(id_assigning_teachers);
            getListStudent(id_assigning_teachers);
            setSubject(res.data.assigning_teachers);
          } else {
            setSelectedValue1(value);
            setSubject(res.data.assigning_teachers);
          }
        }
      })
      .catch((error) => {});
  }

  const [listStudent, setListStudent] = useState([] as any[]);
  function getListStudent(e: any) {
    if (e && e.target && e.target.value) {
      var value = e.target.value;
      // Tiếp tục xử lý dữ liệu...
    }
    // localStorage.removeItem("id_assigning_teachers");
    localStorage.setItem("id_assigning_teachers", e);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");
    var id_assigning_teachers = localStorage.getItem("id_assigning_teachers");
    var id_class_diagram = localStorage.getItem("id_class_diagram");
    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
      id_class_diagram: id_class_diagram,
    };
    api
      .post(`/list_student_class_teacher/` + id_assigning_teachers, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setSelectedValue2(value);
          setListStudent(res.data.content);
          setShowFab(true);
        }
      })
      .catch((error) => {});
  }

  const [listScores, setListScores] = useState([] as any[]);
  const [tb, settb] = useState([] as any[]);
  function getListScores(e: any) {
    localStorage.removeItem("arrange_class");
    localStorage.setItem("arrange_class", e);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });

    const id_arrange_class = e.target.id;
    // var arrange_class = localStorage.getItem("arrange_class");

    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");
    var id_assigning_teachers = localStorage.getItem("id_assigning_teachers");
    var id_class_diagram = localStorage.getItem("id_class_diagram");

    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
      id_class_diagram: id_class_diagram,
      id_assigning_teachers: id_assigning_teachers,
    };
    api
      .post(`/scores_student_class_teacher/` + id_arrange_class, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setListScores(res.data.subject_teacher);
          settb(res.data.tb);
        }
      })
      .catch((error) => {});
  }

  const [semesterNow, setSemesterNow] = useState([] as any[]);
  const [listClass, setListClass] = useState([] as any[]);
  const [liststudentadd, setListstudentadd] = useState([] as any[]);
  const [listSubject, setListSubject] = useState([] as any[]);
  //Lấy thông tin hiện modal
  function getinfo() {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_school_teacher = localStorage.getItem("id_school_teacher");
    var id_class_diagram = localStorage.getItem("id_class_diagram");
    var id_assigning_teachers = localStorage.getItem("id_assigning_teachers");
    const loginData = {
      token: x,
      id_school_teacher: id_school_teacher,
      id_class_diagram: id_class_diagram,
      id_assigning_teachers: id_assigning_teachers,
    };
    api
      .post("/getClass_semester_add_teacher", loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setSemesterNow(res.data.semester.name);
          setListSubject(res.data.subject.subject);
          setListClass(res.data.class.name);
          setListstudentadd(res.data.student_list);
        }
      })
      .catch((error) => {});
  }

  function clickStudent(e: any) {
    localStorage.removeItem("id_arrange_class");
    localStorage.setItem("id_arrange_class", e);
  }
  function clicktypeScore(e: any) {
    localStorage.removeItem("typescore");
    localStorage.setItem("typescore", e);
  }

  const [typeScore, setTypeScore] = useState([] as any[]);
  //Loại điểm
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    const loginData = {
      token: x,
    };
    api
      .post("/typescore_teacher", loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setTypeScore(res.data.typescore);
        }
      })
      .catch((error) => {});
  }, []);

  const [studentScores, setStudentScores] = useState([] as any[]);
  //Thêm điểm
  function addScore() {
    var id_arrange_class = localStorage.getItem("id_arrange_class");
    var typescore = localStorage.getItem("typescore");
    var id_assigning_teachers = localStorage.getItem("id_assigning_teachers");

    // if (!score) {
    //   presentAlert({
    //     header: "Lỗi",
    //     message: "Vui lòng nhập điểm",
    //     buttons: ["OK"],
    //   });
    // }
    // else
    if (!typescore) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng chọn loại điểm",
        buttons: ["OK"],
      });
    } else {
      // localStorage.setItem("id_classNotification", e);
      var id = localStorage.getItem("id_school_teacher");
      var x = localStorage.getItem("token");
      // console.log(studentScores)
      const add_score = {
        scores: studentScores,
        // id_arrange_class: id_arrange_class,
        typescore: typescore,
        id_assigning_teachers: id_assigning_teachers,
        token: x,
        id_school_teacher: id,
      };
      console.log(add_score);
      const api = axios.create({
        baseURL: "https://school.hewo.vn/api",
      });
      api
        .post("/scores_student_add_teacher", add_score)
        .then((res) => {
          if (res.data.status == "error") {
            dismiss();
            presentAlert({
              header: "Lỗi",
              message: res.data.content,
              buttons: ["OK"],
            });
          } else if (res.data.status == "success") {
            console.log(res.data.content);
            dismiss();
            console.log("aaaaaaaa");
            // setScores((prevScores) => [...prevScores, score]);
            // window.location.reload();
          }
        })
        .catch((error) => {
          dismiss();
          presentAlert({
            header: "Lỗi",
            message: "không thể kết nối đến máy chủ",
            buttons: ["OK"],
          });
        });
    }
  }
  const [showFab, setShowFab] = useState(false);

  const [selectedValue, setSelectedValue] = useState<any>(null);
  const [selectedValue1, setSelectedValue1] = useState<any>(null);
  const [selectedValue2, setSelectedValue2] = useState<any>(null);

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            <IonMenuButton />
            {/* <IonBackButton></IonBackButton> */}
          </IonButtons>
          <IonTitle>Bảng điểm học sinh</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        {/* <IonGrid style={{ marginTop: "10px" }}> */}

        <IonCard className="card-home">
          <IonCardContent className="card-content">
            <IonGrid className="py-0">
              <IonRow className="me-2 d-flex align-items-center ms-2">
                <IonCol>
                  <IonLabel className="lable-name">Học kì :</IonLabel>
                </IonCol>
                <IonCol size="9">
                  <div style={{ width: "100%" }}>
                    <select
                      className="select-name w-100"
                      color="primary"
                      slot="start"
                      // interface="popover"
                      placeholder="HỌC KÌ"
                      value={selectedValue}
                      onChange={(e: any) => getListClass(e.target.value)}
                    >
                      {semester.length > 0 ? (
                        <option value={""}>Chọn học kì</option>
                      ) : null}
                      {semester.map((course, key) => {
                        return (
                          <option value={course.id} key={key}>
                            HỌC KÌ {course.name}
                          </option>
                        );
                      })}
                    </select>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>
            <IonGrid className="py-0">
              <IonRow className="me-2 d-flex align-items-center ms-2">
                <IonCol>
                  <IonLabel className="lable-name">Lớp :</IonLabel>
                </IonCol>
                <IonCol size="9">
                  <div style={{ width: "100%" }}>
                    <select
                      className="select-name w-100"
                      color="primary"
                      slot="start"
                      // interface="popover"
                      placeholder="Chọn lớp"
                      value={selectedValue1}
                      onChange={(e: any) => getSubject(e.target.value)}
                    >
                      {clas.length > 0 ? (
                        <option value={""}>Chọn lớp</option>
                      ) : null}
                      {clas.map((clas, key) => {
                        return (
                          <option value={clas.id_class_diagram} key={key}>
                            {clas.name}
                          </option>
                        );
                      })}
                    </select>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>
            <IonGrid className="py-0">
              <IonRow className="me-2 d-flex align-items-center ms-2">
                <IonCol>
                  <IonLabel className="lable-name">Môn học :</IonLabel>
                </IonCol>
                <IonCol size="9">
                  <div style={{ width: "100%" }}>
                    <select
                      className="select-name w-100"
                      color="primary"
                      slot="start"
                      // interface="popover"
                      placeholder="Môn học"
                      value={selectedValue2}
                      onChange={(e: any) => getListStudent(e.target.value)}
                    >
                      {subject.length > 0 ? (
                        <option value={""}>Chọn môn học</option>
                      ) : null}
                      {subject.map((subject, key) => {
                        return (
                          <option value={subject.id_assigning_teachers}>
                            {subject.subject}
                          </option>
                        );
                      })}
                    </select>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>
          </IonCardContent>
        </IonCard>

        <IonAccordionGroup className="mt-2 p-2">
          {listStudent.map((listStudent, key) => {
            return (
              <IonAccordion
                value={listStudent.id_arrange_class}
                className="p-1 bg-color  mb-2"
              >
                <IonItem
                  slot="header"
                  color="red"
                  className="item-Cash "
                  onClick={getListScores}
                  // key={listStudent.id_arrange_class}
                  id={listStudent.id_arrange_class}
                >
                  <div
                    className="item-count bg-color-green"
                    onClick={getListScores}
                    // key={listStudent.id_arrange_class}
                    id={listStudent.id_arrange_class}
                  >
                    {key + 1}
                  </div>

                  <IonLabel
                    className="name"
                    onClick={getListScores}
                    // key={listStudent.id_arrange_class}
                    id={listStudent.id_arrange_class}
                  >
                    {listStudent.firstname} {listStudent.lastname}
                    <p
                      className="mt-2 text-secondary fw-medium"
                      onClick={getListScores}
                      // key={listStudent.id_arrange_class}
                      id={listStudent.id_arrange_class}
                    >
                      Mã học sinh: {listStudent.id_student}
                    </p>
                  </IonLabel>
                </IonItem>
                <div className="p-1" slot="content">
                  <IonCard className="bg-card">
                    <IonCardContent className="card-content-grid-list">
                      {listScores.map((listScores, key) => {
                        return (
                          <IonRow className="row">
                            <IonCol>
                              <IonLabel className="lable-name">
                                {listScores.typescore}:
                              </IonLabel>
                            </IonCol>
                            <IonCol className="tt" size="3">
                              <IonInput>{listScores.scores}</IonInput>
                            </IonCol>
                          </IonRow>
                        );
                      })}

                      <IonRow className="row text-black fw-bold">
                        <IonCol>
                          <IonLabel className="lable-name">
                            Điểm trung bình:
                          </IonLabel>
                        </IonCol>
                        <IonCol className="tt" size="3">
                          <IonInput>{tb}</IonInput>
                        </IonCol>
                      </IonRow>
                    </IonCardContent>
                  </IonCard>
                </div>
              </IonAccordion>
            );
          })}
        </IonAccordionGroup>
        {/* </IonGrid> */}
        {showFab && (
          <>
            <IonFab
              slot="fixed"
              vertical="bottom"
              horizontal="end"
              id="open-modal"
              onClick={getinfo}
            >
              <IonFabButton>
                <IonIcon icon={addOutline}></IonIcon>
              </IonFabButton>
            </IonFab>

            <IonModal
              id="example-modal"
              ref={modal}
              trigger="open-modal"
              enterAnimation={enterAnimation}
              leaveAnimation={leaveAnimation}
              style={{ alignItems: "start" }}
            >
              <IonContent>
                <IonToolbar>
                  <IonTitle color={"white"} style={{ textAlign: "center" }}>
                    Nhập điểm học sinh
                  </IonTitle>
                  <IonButtons slot="end">
                    <IonButton onClick={() => dismiss()}>
                      <IonIcon color={"white"} icon={closeOutline}></IonIcon>
                    </IonButton>
                  </IonButtons>
                </IonToolbar>
                <IonCard>
                  <IonCardContent style={{ height: "100%" }}>
                    <IonLabel className="fs-6">
                      Học kì <b className="text-danger">*</b> :
                    </IonLabel>
                    <IonItem fill="outline" className="mt-2 mb-2">
                      <IonInput className="ps-3 d-flex justify-content-start">
                        <div>Học kì {semesterNow}</div>
                      </IonInput>
                    </IonItem>

                    <IonLabel className="fs-6">
                      Lớp học <b className="text-danger">*</b> :
                    </IonLabel>
                    <IonItem fill="outline" className="mt-2 mb-2">
                      <IonInput className="ps-3">{listClass}</IonInput>
                    </IonItem>

                    <IonLabel className="fs-6">
                      Môn học <b className="text-danger">*</b> :
                    </IonLabel>
                    <IonItem fill="outline" className="mt-2 mb-2">
                      <IonInput className="ps-3">{listSubject}</IonInput>
                    </IonItem>
                    <IonLabel className="fs-6">
                      Chọn loại điểm <b className="text-danger">*</b> :
                    </IonLabel>
                    <IonItem fill="outline" className="mt-2 mb-2">
                      <IonSelect
                        className=" w-100 me-0 justify-content-center d-flex px-2 pt-3"
                        // color="primary"
                        slot="start"
                        interface="popover"
                        placeholder="Chọn loại điểm"
                        style={{ height: "40px" }}
                        onIonChange={(e: any) => clicktypeScore(e.target.value)}
                      >
                        {typeScore.map((typeScore, key) => {
                          return (
                            <IonSelectOption value={typeScore.id} key={key}>
                              {typeScore.name}
                            </IonSelectOption>
                          );
                        })}
                      </IonSelect>
                    </IonItem>

                    <IonLabel className="fs-6">
                      Học sinh <b className="text-danger">*</b> :
                    </IonLabel>
                    <div className="two-row-list-container">
                      <IonList>
                        {liststudentadd.map((liststudentadd, key) => {
                          return (
                            <IonRow>
                              <IonCol size="2">
                                {liststudentadd.id_student}
                              </IonCol>
                              <IonCol size="8">
                                {liststudentadd.firstname}{" "}
                                {liststudentadd.lastname}
                              </IonCol>
                              <IonCol size="2">
                                <IonInput
                                  type="number"
                                  placeholder="0.0"
                                  // value={studentScores[key] || ""}
                                  onIonChange={(e: any) => {
                                    const score = e.target.value;
                                    const updatedStudentScores = [
                                      ...studentScores,
                                    ];
                                    updatedStudentScores[key] = {
                                      id: liststudentadd.id_arrange_class,
                                      score: score,
                                    };
                                    setStudentScores(updatedStudentScores);
                                  }}
                                ></IonInput>
                              </IonCol>
                            </IonRow>
                          );
                        })}
                      </IonList>
                    </div>
                    {/* <IonItem fill="outline" className="mt-2 mb-2">
                      <IonSelect
                        className=" w-100 me-0 justify-content-center d-flex px-2 pt-3"
                        // color="primary"
                        slot="start"
                        interface="popover"
                        placeholder="Học sinh"
                        style={{ height: "40px" }}
                        onIonChange={(e: any) => clickStudent(e.target.value)}
                      >
                        {liststudentadd.map((liststudentadd, key) => {
                          return (
                            <IonSelectOption
                              value={liststudentadd.id_arrange_class}
                              key={key}
                            >
                              {liststudentadd.id_student}-
                              {liststudentadd.firstname}{" "}
                              {liststudentadd.lastname}
                            </IonSelectOption>
                          );
                        })}
                      </IonSelect>
                    </IonItem> */}

                    {/* <IonLabel className="fs-6">
                      Nhập điểm <b className="text-danger">*</b> :
                    </IonLabel>
                    <IonItem fill="outline" className="mt-2 mb-2">
                      <IonInput
                        className="ps-3"
                        placeholder="Nhập điểm"
                        onIonChange={(e: any) => setScore(e.target.value)}
                      ></IonInput>
                    </IonItem> */}

                    <IonRow
                      class="row-btn"
                      style={{ textAlign: "center", marginTop: "20px" }}
                    >
                      <IonCol>
                        <IonButton
                          onClick={() => dismiss()}
                          color="medium"
                          className="w-75"
                        >
                          HỦY
                        </IonButton>
                      </IonCol>
                      <IonCol>
                        <IonButton
                          color="tertiary"
                          className="w-75"
                          onClick={addScore}
                        >
                          THÊM
                        </IonButton>
                      </IonCol>
                    </IonRow>
                  </IonCardContent>
                </IonCard>
              </IonContent>
            </IonModal>
          </>
        )}
      </IonContent>
    </IonPage>
  );
};

export default OpinionDetail;
