import {
  IonAccordion,
  IonAccordionGroup,
  IonButton,
  IonButtons,
  IonCard,
  IonCardContent,
  IonCol,
  IonContent,
  IonGrid,
  IonHeader,
  IonIcon,
  IonImg,
  IonInput,
  IonItem,
  IonLabel,
  IonMenuButton,
  IonPage,
  IonRow,
  IonSearchbar,
  IonSelect,
  IonSelectOption,
  IonTextarea,
  IonTitle,
  IonToast,
  IonToolbar,
  useIonAlert,
} from "@ionic/react";
import { cubeSharp, key, starSharp } from "ionicons/icons";

import "./NoteBook.css";
import { useEffect, useState } from "react";
import axios from "axios";

const OpinionDetail: React.FC = () => {
  const [subject, setSubject] = useState([] as any[]);

  const [classTeacher, setclassTeacher] = useState([] as any[]);
  const [selectedValue, setSelectedValue] = useState<any>(null);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");
    var id_class_diagram = localStorage.getItem("id_class_diagram");
    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
    };

    api
      .post(`/class_teacher`, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.class == null) {
            setclassTeacher([]);
          } else if (id_class_diagram) {
            setSelectedValue(id_class_diagram);
            getNoteBook(id_class_diagram);
            setclassTeacher(res.data.class);
          } else {
            setclassTeacher(res.data.class);
          }
        }
      })
      .catch((error) => {});
  }, []);
  const [mon, setMon] = useState([] as any[]);
  const [tues, setTues] = useState([] as any[]);
  const [wed, setWed] = useState([] as any[]);
  const [thurs, setThurs] = useState([] as any[]);
  const [fri, setFri] = useState([] as any[]);
  const [sat, setSat] = useState([] as any[]);
  const [sun, setSun] = useState([] as any[]);

  const [activeTab, setActiveTab] = useState("");

  function getNoteBook(e: any) {
    if (e && e.target && e.target.value) {
      var value = e.target.value;
      // Tiếp tục xử lý dữ liệu...
    }
    // const current = new Date();
    // const date = `${current.getFullYear()}-${
    //   current.getMonth() + 1
    // }-${current.getDate()}`;
    // console.log(date);
    // setActiveTab(date);

    localStorage.removeItem("id_class_diagram");
    localStorage.setItem("id_class_diagram", e);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");
    var id_class_diagram = localStorage.getItem("id_class_diagram");

    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
      id_class_diagram: id_class_diagram,
    };
    api
      .post(`/firstbook_teacher`, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setSelectedValue(value);
          setActiveTab(res.data.thu.id);
          console.log(res.data.thu.id);
          const monday = res.data.weekDays.Monday;
          setMon(monday);
          const tuesday = res.data.weekDays.Tuesday;
          setTues(tuesday);
          const wedday = res.data.weekDays.Wednesday;
          setWed(wedday);
          const thursday = res.data.weekDays.Thursday;
          setThurs(thursday);
          const friday = res.data.weekDays.Friday;
          setFri(friday);
          const satday = res.data.weekDays.Saturday;
          setSat(satday);
          const sunday = res.data.weekDays.Sunday;
          setSun(sunday);
          localStorage.removeItem("date_subject");
          localStorage.setItem("date_subject", monday);
          if (res.data.subject == null) {
            setSubject([]);
            setShowToast(true);
          } else {
            setSubject(res.data.subject);
          }
        }
      })
      .catch((error) => {});
  }

  const [showToast, setShowToast] = useState(false);
  function handleItemClick(event: any) {
    const itemId = event.target.id;
    localStorage.removeItem("date_subject");
    localStorage.setItem("date_subject", itemId);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");
    var id_class_diagram = localStorage.getItem("id_class_diagram");
    var date_subject = localStorage.getItem("date_subject");
    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
      id_class_diagram: id_class_diagram,
      // date_subject: date_subject
    };

    api
      .post(`/firstbook_teacher_clickdate/` + date_subject, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.subject == null) {
            setShowToast(true);
            setSubject([]);
          } else {
            setActiveTab(res.data.thu.id);
            console.log(res.data.thu.id);
            console.log("abvdsfsbfiosc");
            // const monday=res.data.weekDays.Monday;
            // setMon(monday);
            // const tuesday=res.data.weekDays.Tuesday;
            // setTues(tuesday);
            // const wedday=res.data.weekDays.Wednesday;
            // setWed(wedday);
            // const thursday=res.data.weekDays.Thursday;
            // setThurs(thursday);
            // const friday=res.data.weekDays.Friday;
            // setFri(friday);
            // const satday=res.data.weekDays.Saturday;
            // setSat(satday);
            // const sunday=res.data.weekDays.Sunday;
            // setSun(sunday);
            setSubject(res.data.subject);
          }
        }
      })
      .catch((error) => {});
  }

  function searchFirstBook(e: any) {
    // const itemId = event.target.id;
    // localStorage.removeItem("date_subject");
    // localStorage.setItem("date_subject", itemId);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");
    var id_class_diagram = localStorage.getItem("id_class_diagram");
    var date_subject = localStorage.getItem("date_subject");
    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
      id_class_diagram: id_class_diagram,
      // date_subject: date_subject
    };

    api
      .post(`/firstbook_teacher_search/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setActiveTab(res.data.thu.id);
          console.log(res.data.thu.id);
          const monday = res.data.weekDays.Monday;
          setMon(monday);
          const tuesday = res.data.weekDays.Tuesday;
          setTues(tuesday);
          const wedday = res.data.weekDays.Wednesday;
          setWed(wedday);
          const thursday = res.data.weekDays.Thursday;
          setThurs(thursday);
          const friday = res.data.weekDays.Friday;
          setFri(friday);
          const satday = res.data.weekDays.Saturday;
          setSat(satday);
          const sunday = res.data.weekDays.Sunday;
          setSun(sunday);
          console.log("bhdab", res.data.weekDays);
          if (res.data.subject == null) {
            setShowToast(true);
            setSubject([]);
          } else {
            console.log("abvdsfsbfiosc");
            localStorage.removeItem("todayy");
            localStorage.setItem("todayy", e);
            setSubject(res.data.subject);
          }
        }
      })
      .catch((error) => {});
  }

  function clickXL(e: any) {
    localStorage.removeItem("evaluate");
    localStorage.setItem("evaluate", e);
  }

  const [presentAlert] = useIonAlert();
  const [title, setTitle] = useState("");
  const [content, setContent] = useState("");
  const [comment, setComment] = useState("");
  // const [evaluate, setEvaluate] = useState("");
  function addFirstBook(lesson: any, subject_id: any) {
    localStorage.removeItem("lesson");
    localStorage.setItem("lesson", lesson);
    localStorage.removeItem("subject_id");
    localStorage.setItem("subject_id", subject_id);
    var evaluate = localStorage.getItem("evaluate");
    if (!title) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập tiêu đề",
        buttons: ["OK"],
      });
    } else if (!content) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập nội dung",
        buttons: ["OK"],
      });
    } else if (!comment) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập nhận xét",
        buttons: ["OK"],
      });
    } else if (!evaluate) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng chọn xếp loại",
        buttons: ["OK"],
      });
    }

    var id = localStorage.getItem("id_school_teacher");
    var x = localStorage.getItem("token");
    var date_subject = localStorage.getItem("date_subject");
    var subject = localStorage.getItem("subject_id");
    var lesson_id = localStorage.getItem("lesson");
    // var id_course = localStorage.getItem("id_course");
    var id_class_diagram = localStorage.getItem("id_class_diagram");

    // var lesson = localStorage.getItem("lesson");
    const add_firstBook = {
      title: title,
      content: content,
      comment: comment,
      evaluate: evaluate,
      token: x,
      id_school_teacher: id,
      // id_course: id_course,
      id_class_diagram: id_class_diagram,
      subject_id: subject,
      date_subject: date_subject,
    };

    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    api
      .post("/firstbook_add_firstbook/" + lesson_id, add_firstBook)
      .then((res) => {
        if (res.data.status == "error") {
          // dismiss();
          presentAlert({
            header: "Lỗi",
            message: res.data.content,
            buttons: ["OK"],
          });
        } else if (res.data.status == "success") {
          // localStorage.setItem("id_classNotification", e);
          console.log(res.data.content);
          // dismiss();
          window.location.reload();
          // localStorage.removeItem("id_classNotification");
        }
      })
      .catch((error) => {
        // dismiss();
        presentAlert({
          header: "Lỗi",
          message: "không thể kết nối đến máy chủ",
          buttons: ["OK"],
        });
      });
  }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            <IonMenuButton />
            {/* <IonBackButton></IonBackButton> */}
          </IonButtons>
          <IonTitle>Sổ đầu bài</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        {/* <IonGrid style={{ marginTop: "10px" }}> */}
        <IonToast
          isOpen={showToast}
          message="Không tìm thấy dữ liệu."
          duration={3000}
          onDidDismiss={() => setShowToast(false)}
          position="top"
          color="danger"
          cssClass="my-toast"
          buttons={[
            {
              text: "Đóng",
              role: "cancel",
              handler: () => {
                setShowToast(false);
              },
            },
          ]}
        />
        <IonCard className="card-home">
          <IonCardContent className="card-content">
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
                      value={selectedValue}
                      onChange={(e: any) => getNoteBook(e.target.value)}
                    >
                      
                      {classTeacher.map((classTeacher, key) => {
                        return (
                          <option
                            key={key}
                            value={classTeacher.id_class_diagram}
                          >
                            {classTeacher.name}
                          </option>
                        );
                      })}
                    </select>
                  </div>
                </IonCol>
              </IonRow>
              <IonRow className="me-2 d-flex align-items-center ms-2">
                <IonCol>
                  <IonLabel className="lable-name">Ngày :</IonLabel>
                </IonCol>
                <IonCol size="9">
                  <div style={{ width: "100%" }}>
                    <IonInput
                      type="date"
                      className="bg-white p-1"
                      onIonChange={(e: any) => searchFirstBook(e.target.value)}
                    ></IonInput>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>
          </IonCardContent>
        </IonCard>
        <div className="card border-0 border-top mt-3">
          <div className="card-header">
            <ul
              className="nav nav-pills  d-flex justify-content-around"
              id="pills-tab"
              role="tablist"
            >
              <li className="nav-item" role="presentation">
                <button
                  className={`nav-link ${activeTab === "1" ? "active" : ""}`}
                  id={`${mon}`}
                  onClick={handleItemClick}
                  data-bs-toggle="pill"
                  data-bs-target="#1"
                  type="button"
                  role="tab"
                  aria-controls="pills-home"
                  aria-selected={activeTab === "1"}
                >
                  T2
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  className={`nav-link ${activeTab === "2" ? "active" : ""}`}
                  id={`${tues}`}
                  onClick={handleItemClick}
                  data-bs-toggle="pill"
                  data-bs-target="#2"
                  type="button"
                  role="tab"
                  aria-controls="pills-profile"
                  aria-selected={activeTab === "2"}
                >
                  T3
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  className={`nav-link ${activeTab === "3" ? "active" : ""}`}
                  id={`${wed}`}
                  onClick={handleItemClick}
                  data-bs-toggle="pill"
                  data-bs-target="#3"
                  type="button"
                  role="tab"
                  aria-controls="pills-contact"
                  aria-selected={activeTab === "3"}
                >
                  T4
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  className={`nav-link ${activeTab === "4" ? "active" : ""}`}
                  id={`${thurs}`}
                  onClick={handleItemClick}
                  data-bs-toggle="pill"
                  data-bs-target="#4"
                  type="button"
                  role="tab"
                  aria-controls="pills-contact"
                  aria-selected={activeTab === "4"}
                >
                  T5
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  className={`nav-link ${activeTab === "5" ? "active" : ""}`}
                  id={`${fri}`}
                  onClick={handleItemClick}
                  data-bs-toggle="pill"
                  data-bs-target="#5"
                  type="button"
                  role="tab"
                  aria-controls="pills-contact"
                  aria-selected={activeTab === "5"}
                >
                  T6
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  className={`nav-link ${activeTab === "6" ? "active" : ""}`}
                  id={`${sat}`}
                  onClick={handleItemClick}
                  data-bs-toggle="pill"
                  data-bs-target="#6"
                  type="button"
                  role="tab"
                  aria-controls="pills-contact"
                  aria-selected={activeTab === "6"}
                >
                  T7
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  className={`nav-link ${activeTab === "7" ? "active" : ""}`}
                  id={`${sun}`}
                  onClick={handleItemClick}
                  data-bs-toggle="pill"
                  data-bs-target="#7"
                  type="button"
                  role="tab"
                  aria-controls="pills-contact"
                  aria-selected={activeTab === "7"}
                >
                  CN
                </button>
              </li>
            </ul>
          </div>
          <form className="card-body tab-content">
            <div className="tab-pane active" id="1" aria-labelledby="1">
              <div className="row d-flex justify-content-between mt-1">
                <div className=" d-flex justify-content-center">
                  <div className="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                    {subject.map((subject, key) => {
                      if (subject.lesson_id == 1) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 2) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 3) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 4) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 5) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 6) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 7) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 8) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 9) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 10) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      }
                    })}
                  </div>
                </div>
              </div>
            </div>
            <div className="tab-pane" id="2" aria-labelledby="2">
              <div className="row d-flex justify-content-between mt-1">
                <div className=" d-flex justify-content-center">
                  <div className="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                    {subject.map((subject, key) => {
                      if (subject.lesson_id == 1) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 2) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 3) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 4) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 5) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 6) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 7) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 8) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 9) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 10) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      }
                    })}
                  </div>
                </div>
              </div>
            </div>
            <div className="tab-pane" id="3" aria-labelledby="3">
              <div className="row d-flex justify-content-between mt-1">
                <div className=" d-flex justify-content-center">
                  <div className="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                    {subject.map((subject, key) => {
                      if (subject.lesson_id == 1) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 2) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 3) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 4) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 5) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 6) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 7) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 8) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 9) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 10) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      }
                    })}
                  </div>
                </div>
              </div>
            </div>
            <div className="tab-pane" id="4" aria-labelledby="4">
              <div className="row d-flex justify-content-between mt-1">
                <div className=" d-flex justify-content-center">
                  <div className="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                    {subject.map((subject, key) => {
                      if (subject.lesson_id == 1) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 2) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 3) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 4) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 5) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 6) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 7) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 8) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 9) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 10) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      }
                    })}
                  </div>
                </div>
              </div>
            </div>
            <div className="tab-pane" id="5" aria-labelledby="5">
              <div className="row d-flex justify-content-between mt-1">
                <div className=" d-flex justify-content-center">
                  <div className="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                    {subject.map((subject, key) => {
                      if (subject.lesson_id == 1) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 2) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 3) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 4) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 5) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 6) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 7) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 8) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 9) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 10) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      }
                    })}
                  </div>
                </div>
              </div>
            </div>
            <div className="tab-pane" id="6" aria-labelledby="6">
              <div className="row d-flex justify-content-between mt-1">
                <div className=" d-flex justify-content-center">
                  <div className="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                    {subject.map((subject, key) => {
                      if (subject.lesson_id == 1) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 2) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 3) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 4) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 5) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 6) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 7) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 8) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 9) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 10) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      }
                    })}
                  </div>
                </div>
              </div>
            </div>
            <div className="tab-pane" id="7" aria-labelledby="7">
              <div className="row d-flex justify-content-between mt-1">
                <div className=" d-flex justify-content-center">
                  <div className="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                    {subject.map((subject, key) => {
                      if (subject.lesson_id == 1) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 1</p>
                                    6h30-7h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 2) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFDAB9",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 2</p>
                                    7h30-8h20
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 3) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFFFCC",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 3</p>
                                    8h20-9h10
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 4) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#CCFFFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 4</p>
                                    9h10-10h00
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 5) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFCCFF",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 5</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 6) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#E0EEE0",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 6</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 7) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#ADD8E6",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 7</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 8) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#D3D3D3",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 8</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 9) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 9</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else if (subject.lesson_id == 10) {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFB6C1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết 10</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      } else {
                        if (subject.evaluate != null) {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel className="ps-2">
                                        <h6>Tiêu đề:</h6> {subject.title}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6>Tên bài, nội dung:</h6>{" "}
                                        {subject.content}
                                      </IonLabel>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel className="ps-2">
                                        <h6> Nhận xét của giáo viên:</h6>{" "}
                                        {subject.comment}
                                      </IonLabel>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <p className="fs-6">
                                            Xếp loại: {subject.evaluate}
                                          </p>
                                        </div>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        } else {
                          return (
                            <div className="vertical-timeline-item vertical-timeline-element">
                              <div>
                                <span className="vertical-timeline-element-icon bounce-in">
                                  <IonIcon
                                    className="badge-dot-xl"
                                    icon={cubeSharp}
                                    size="large"
                                    color="tertiary"
                                  ></IonIcon>
                                </span>
                                <div className="vertical-timeline-element-content bounce-in">
                                  <div
                                    style={{
                                      marginLeft: "10px",
                                      padding: "10px",
                                      backgroundColor: "#FFE4E1",
                                      borderRadius: "10px",
                                    }}
                                  >
                                    <p>Môn học: {subject.subject}</p>
                                    <h4 className="timeline-title">
                                      Giáo viên : {subject.firstname_teachers}{" "}
                                      {subject.lastname_teachers}
                                    </h4>
                                    <IonItem fill="outline">
                                      <IonLabel position="floating">
                                        Tiêu đề:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setTitle(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Tên bài, nội dung:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setContent(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonItem fill="outline" className="mt-2">
                                      <IonLabel position="floating">
                                        Nhận xét của giáo viên:
                                      </IonLabel>
                                      <IonTextarea
                                        placeholder=""
                                        onIonChange={(e: any) =>
                                          setComment(e.target.value)
                                        }
                                      ></IonTextarea>
                                    </IonItem>
                                    <IonRow className="d-flex align-items-center">
                                      <IonCol size="5">
                                        <div style={{ width: "100%" }}>
                                          <IonSelect
                                            className="select-name bg-white rounded-2"
                                            // color="light"
                                            slot="start"
                                            interface="popover"
                                            placeholder="Xếp loại"
                                            onIonChange={(e: any) =>
                                              clickXL(e.target.value)
                                            }
                                          >
                                            <IonSelectOption value="A">
                                              A
                                            </IonSelectOption>
                                            <IonSelectOption value="B">
                                              B
                                            </IonSelectOption>
                                            <IonSelectOption value="C">
                                              C
                                            </IonSelectOption>
                                            <IonSelectOption value="D">
                                              D
                                            </IonSelectOption>
                                          </IonSelect>
                                        </div>
                                      </IonCol>
                                      <IonCol className="justify-content-end d-flex">
                                        <IonButton
                                          size="small"
                                          color={"warning"}
                                          className="fw-bold w-50"
                                          expand="block"
                                          // onClick={addNotificationTeacher}
                                          onClick={(event) => {
                                            addFirstBook(
                                              subject.lesson_id,
                                              subject.subject_id
                                            );
                                          }}
                                        >
                                          Lưu
                                        </IonButton>
                                      </IonCol>
                                    </IonRow>
                                  </div>
                                  <div className="vertical-timeline-element-date">
                                    <p>Tiết {subject.lesson_id}</p>
                                    10h00-10h50
                                  </div>
                                </div>
                              </div>
                            </div>
                          );
                        }
                      }
                    })}
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </IonContent>
    </IonPage>
  );
};

export default OpinionDetail;
