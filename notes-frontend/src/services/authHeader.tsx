
export default function authHeader(): Record<string, string> {
  //const user = JSON.parse(localStorage.getItem("token") || "{}");
  const token = localStorage.getItem("token") || "{}";


  if (token) {
    return { "Authorization": `Bearer ${token}` };
  } else {
    return {};
  }
}
