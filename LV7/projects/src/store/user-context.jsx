import { createContext, useState, useEffect } from "react";

export const UserContext = createContext({
  user: null,
  setUser: () => {},
});

export default function UserContextProvider({ children }) {
  const [user, setUser] = useState(() => {
    // Load user from localStorage if it exists
    const storedUser = localStorage.getItem("user");
    return storedUser ? JSON.parse(storedUser) : null;
  });

  useEffect(() => {
    if (user) {
      localStorage.setItem("user", JSON.stringify(user));
    } else {
      localStorage.removeItem("user");
    }
  }, [user]);

  const ctxValue = {
    user,
    setUser,
  };

  return (
    <UserContext.Provider value={ctxValue}>{children}</UserContext.Provider>
  );
}
