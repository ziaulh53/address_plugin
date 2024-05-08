export const fetchData = async (action,data) => {
  try {
    const response = await jQuery.get(ajaxurl, {action, ...data}, function(data) {
        return data;
    });
    return response || {};
  } catch (error) {
    console.error("Error:", error);
  }
};

export const saveData = async (action,data) => {
    try {
      const res = await jQuery.post(ajaxurl, {action, ...data}, function(data) {
          return data;
      });
      return res?.data || {};
    } catch (error) {
      console.error("Error:", error);
    }
  };

  export const deleteData = async (action, id)=>{
    try {
        const res = await jQuery.post(ajaxurl, {action, id}, function(data) {
            return data;
        })
        return res?.data;
    } catch (error) {
        
    }
  }

  export const updateData = async(action,data)=>{
    try {
      const res = await jQuery.post(ajaxurl, {action, ...data}, function(data){
        return data;
      })

      return res?.data;
    } catch (error) {
      
    }
  }
