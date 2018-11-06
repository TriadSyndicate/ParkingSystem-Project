const admin = require('firebase-admin');

var serviceAccount = require('./servicekey.json');

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount)
});

var db = admin.firestore();

var docRef = db.collection('foods').doc();

var setAda = docRef.set({
  food_id: '4',
  food_name: 'Pasta',
  food_price: 70
});

/*db.collection('foods').get()
    .then((snapshot) => {
      snapshot.forEach((doc) => {
        console.log(doc.id, '=>', doc.data());
      });
    })
    .catch((err) => {
      console.log('Error getting documents', err);
    });*/
