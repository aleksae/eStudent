import pandas as pd
from joblib import load


def load_model(model_path='random_forest_model.joblib', columns_path='X_columns.joblib'):
    model = load(model_path)
    X_columns = load(columns_path)
    return model, X_columns


def predict_acceptance___(model, X_columns, school_name, student_grade):
    new_data = {'student_grade': student_grade}

    school_column = f'school_name_{school_name}'
    if school_column not in X_columns:
        raise ValueError(f"School '{school_name}' is not recognized. Please check the school name.")
    new_data[school_column] = 1

    new_df = pd.DataFrame([new_data])
    for col in X_columns:
        if col not in new_df.columns:
            new_df[col] = 0

    new_df = new_df[X_columns]

    prediction = model.predict(new_df)
    return  prediction[0] == 1

def predict(school_name,student_grade): #ovo se koristi u notepadu se nalaze string vrednosti za podrzane skole
    model, X_columns = load_model()
    return predict_acceptance___(model, X_columns, school_name, student_grade)

