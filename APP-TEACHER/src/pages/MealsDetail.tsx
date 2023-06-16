import {
  IonBackButton,
  IonButtons,
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardSubtitle,
  IonCardTitle,
  IonContent,
  IonHeader,
  IonPage,
  IonTitle,
  IonToolbar,
} from "@ionic/react";
import axios from "axios";
import React, { useEffect, useState } from "react";

const MealsDetail: React.FC = () => {
  const [mealDetails, setMealDetails] = useState([] as any[]);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_MealDetails");
    const loginData = {
      token: x,
      id_MealDetails: id,
    };
    api
      .post(`/dish/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setMealDetails(res.data.content);
        }
      })
      .catch((error) => {});
  }, []);

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Chi tiết món ăn</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        {mealDetails.map((mealDetails, key) => {
          return (
            <IonCard style={{ marginTop: "10px", borderRadius: "15px" }}>
              <img
                alt="Silhouette of mountains"
                src={`${mealDetails.avatar}`}
              />
              <IonCardHeader>
                <IonCardTitle style={{ color: "#e8590c" }}>
                  {mealDetails.name}
                </IonCardTitle>
                <IonCardSubtitle style={{ color: "#fd7e14" }}>
                  517 Kcal
                </IonCardSubtitle>
              </IonCardHeader>

              <IonCardContent style={{ textAlign: "justify" }}>
                {mealDetails.content}
              </IonCardContent>
            </IonCard>
          );
        })}
      </IonContent>
    </IonPage>
  );
};
export default MealsDetail;
