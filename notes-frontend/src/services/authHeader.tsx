
export default function authHeader(): Record<string, string> {
  const user = JSON.parse(localStorage.getItem("user") || "{}");

  if (user && user.accessToken) {
    // return { Authorization: 'Bearer ' + user.accessToken };
    return { "Authorization": user.accessToken };
  } else {
    return {};
  }
}
